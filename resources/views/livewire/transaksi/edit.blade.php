<?php

use Livewire\Volt\Component;
use App\Models\Transaksi;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

new #[Layout('components.layouts.app')] class extends Component {
    public Transaksi $transaksi;

    #[Validate('required|exists:users,id')]
    public $user_id;

    #[Validate('required|exists:Penyewa,id')]
    public $penyewa_id;

    #[Validate('required|exists:room,id')]
    public $room_id;

    #[Validate('required|date')]
    public $date;

    public function mount($id)
    {
        $this->transaksi = Transaksi::findOrFail($id);
        $this->user_id = $this->transaksi->user_id;
        $this->penyewa_id = $this->transaksi->penyewa_id;
        $this->room_id = $this->transaksi->room_id;
        $this->date = $this->transaksi->date;
    }

    public function update()
    {
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

    public function with(): array
    {
        return [
            'transaksi' => $this->transaksi
        ];
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

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <form wire:submit="update" class="space-y-6">
                    <!-- User ID -->
                    <div>
                        <flux:select wire:model="user_id" label="Pengguna" required>
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

                    <!-- Penyewa ID -->
                    <div>
                        <flux:select wire:model="penyewa_id" label="Penyewa" required>
                            <option value="">Pilih Penyewa</option>
                            @foreach (\App\Models\Penyewa::all() as $penyewa)
                                <option value="{{ $penyewa->id }}" {{ $penyewa->id == $penyewa_id ? 'selected' : '' }}>
                                    {{ $penyewa->user->name }}
                                </option>
                            @endforeach
                        </flux:select>
                        @error('penyewa_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room ID -->
                    <div>
                        <flux:select wire:model="room_id" label="Ruangan" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach (\App\Models\Room::all() as $room)
                                <option value="{{ $room->id }}" {{ $room->id == $room_id ? 'selected' : '' }}>
                                    {{ $room->Nama_ruangan }}
                                </option>
                            @endforeach
                        </flux:select>
                        @error('room_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <flux:input wire:model="date" label="Tanggal" type="date" required />
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
            </div>
        </div>
    </div>
</div>