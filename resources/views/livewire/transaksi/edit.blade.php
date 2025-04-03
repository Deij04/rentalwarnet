<?php

use Livewire\Volt\Component;
use App\Models\Transaksi;
use App\Models\Room;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new #[Layout('components.layouts.app')] class extends Component {
    public Transaksi $transaksi;

    #[Validate('required|exists:users,id')]
    public $user_id;

    #[Validate('required|exists:users,id')]
    public $penyewa_id;

    #[Validate('required|exists:room,id')]
    public $room_id;

    #[Validate('required|date|after_or_equal:today')]
    public $date;

    public $rooms;
    public $users;
    public $role;

    public function mount($id)
    {
        $user = Auth::user();

        // Check permission
        if (!$user->hasPermissionTo('mengelola Transaksi')) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit transaksi.');
        }

        // Load the transaction
        $this->transaksi = Transaksi::findOrFail($id);

        // Role-based access control
        $this->role = $user->hasRole('Admin') ? 'Admin' : 'Penyewa';
        if ($this->role === 'Penyewa' && $this->transaksi->penyewa_id !== $user->id) {
            abort(403, 'Anda hanya dapat mengedit transaksi Anda sendiri.');
        }

        // Load dropdown data
        $this->rooms = Room::all();
        $this->users = User::role('Penyewa')->get(); // Only Penyewa users for the dropdown

        // Initialize form fields
        $this->user_id = $this->transaksi->user_id;
        $this->penyewa_id = $this->transaksi->penyewa_id;
        $this->room_id = $this->transaksi->room_id;
        $this->date = $this->transaksi->date->toDateString(); // Format date for input

        // Check if rooms are available
        if ($this->rooms->isEmpty()) {
            session()->flash('error', 'Tidak ada ruangan yang tersedia. Silakan tambahkan ruangan terlebih dahulu.');
        }
    }

    public function update()
    {
        $user = Auth::user();

        // Ensure Penyewa cannot change their own ID
        if ($this->role === 'Penyewa' && $this->penyewa_id !== $user->id) {
            session()->flash('error', 'Pengguna dengan role Penyewa tidak dapat mengubah penyewa transaksi.');
            return;
        }

        $this->validate();

        $this->transaksi->update([
            'user_id' => $this->user_id,
            'penyewa_id' => $this->penyewa_id,
            'room_id' => $this->room_id,
            'date' => $this->date,
        ]);

        session()->flash('message', 'Data transaksi berhasil diperbarui.');
        return redirect()->route('transaksi.index');
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Transaksi</h1>
                <a href="{{ route('transaksi.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                @if ($rooms->isEmpty())
                <p class="text-red-500">Tidak ada ruangan yang tersedia. Harap tambahkan ruangan terlebih dahulu.</p>
                @else
                <form wire:submit="update" class="space-y-6">
                    <!-- Nama Pengguna -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Pengguna
                        </label>
                        <flux:select wire:model="user_id" required>
                            <option value="">Pilih Pengguna</option>
                            @foreach (\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </flux:select>
                        @error('user_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Penyewa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Penyewa
                        </label>
                        @if ($role === 'Admin')
                        <flux:select wire:model="penyewa_id" required>
                            <option value="">Pilih Penyewa</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $penyewa_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </flux:select>
                        @else
                        <input type="text" value="{{ Auth::user()->name }}" disabled
                            class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 bg-gray-100 dark:bg-zinc-900 dark:border-zinc-700 text-gray-500" />
                        @endif
                        @error('penyewa_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Ruangan -->
                    <div>
                        <flux:select wire:model="room_id" label="Nama Ruangan" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id == $room_id ? 'selected' : '' }}>
                                {{ $room->Nama_ruangan }}
                            </option>
                            @endforeach
                        </flux:select>
                        @error('room_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Booking -->
                    <div>
                        <flux:input wire:model="date" label="Tanggal Booking" type="date" required />
                        @error('date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end gap-3">
                        <flux:button type="submit" variant="primary">
                            Simpan Perubahan
                        </flux:button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>