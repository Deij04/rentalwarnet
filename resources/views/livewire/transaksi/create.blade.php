<?php

use Livewire\Volt\Component;
use App\Models\Transaksi;
use App\Models\Room;
use App\Models\Penyewa;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new #[Layout('components.layouts.app')] class extends Component {
    #[Validate('required|exists:users,id')]
    public $user_id = '';

    #[Validate('required|exists:penyewa,id')]
    public $penyewa_id = '';

    #[Validate('required|exists:room,id')]
    public $room_id = '';

    #[Validate('required|date')]
    public $date = '';

    public $harga_sewa = null; // Untuk menyimpan harga sewa dari ruangan yang dipilih
    public $isPenyewa = false; // Untuk menentukan apakah pengguna adalah penyewa
    public $errorMessage = null; // Untuk menyimpan pesan error jika ada masalah

    public function mount()
    {
        // Cek apakah pengguna yang login memiliki role "penyewa"
        $this->isPenyewa = Auth::user()->role === 'penyewa';

        if ($this->isPenyewa) {
            // Jika role adalah penyewa, isi otomatis user_id dan penyewa_id
            $this->user_id = Auth::id();

            // Cari entri penyewa berdasarkan user_id
            $penyewa = Penyewa::where('user_id', Auth::id())->first();

            if ($penyewa) {
                $this->penyewa_id = $penyewa->id;
            } else {
                // Jika tidak ada entri penyewa, tampilkan pesan error
                $this->errorMessage = 'Anda belum terdaftar sebagai penyewa. Silakan hubungi admin.';
            }
        }
    }

    // Update harga sewa ketika room_id berubah
    public function updatedRoomId($value)
    {
        if ($value) {
            $room = Room::find($value);
            $this->harga_sewa = $room ? $room->Harga_sewa : null;
        } else {
            $this->harga_sewa = null;
        }
    }

    public function create()
    {
        // Jika ada pesan error (misalnya penyewa tidak ditemukan), hentikan proses
        if ($this->errorMessage) {
            session()->flash('error', $this->errorMessage);
            return;
        }

        $this->validate();

        Transaksi::create([
            'user_id' => $this->user_id,
            'penyewa_id' => $this->penyewa_id,
            'room_id' => $this->room_id,
            'date' => $this->date,
        ]);

        session()->flash('message', 'Data transaksi berhasil ditambahkan.');
        return redirect()->route('transaksi.index');
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Tambah Transaksi Baru</h1>
                <a href="{{ route('transaksi.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <!-- Tampilkan pesan error jika ada -->
                @if($errorMessage)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-4" role="alert">
                        <span class="block sm:inline">{{ $errorMessage }}</span>
                    </div>
                @endif

                <!-- Tampilkan pesan sukses atau error dari session -->
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form wire:submit="create" class="space-y-6">
                    <!-- User ID -->
                    @if(!$isPenyewa)
                        <div>
                            <flux:select wire:model="user_id" label="Pengguna" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach (\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    @else
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Pengguna</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                        </div>
                    @endif

                    <!-- Penyewa ID -->
                    @if(!$isPenyewa)
                        <div>
                            <flux:select wire:model="penyewa_id" label="Penyewa" required>
                                <option value="">Pilih Penyewa</option>
                                @foreach (\App\Models\Penyewa::all() as $penyewa)
                                    <option value="{{ $penyewa->id }}">{{ $penyewa->user->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('penyewa_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Room ID -->
                    <div>
                        <flux:select wire:model="room_id" label="Ruangan" required>
                            <option value="">Pilih Ruangan</option>
                            @foreach (\App\Models\Room::all() as $room)
                                <option value="{{ $room->id }}">{{ $room->Nama_ruangan }}</option>
                            @endforeach
                        </flux:select>
                        @error('room_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Sewa (Hanya Ditampilkan) -->
                    @if($harga_sewa !== null)
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Harga Sewa</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ number_format($harga_sewa, 2, ',', '.') }}</p>
                        </div>
                    @endif

                    <!-- Tanggal -->
                    <div>
                        <flux:input wire:model="date" label="Tanggal" type="date" required />
                        @error('date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end gap-3">
                        <flux:button type="submit" variant="primary" {{ $errorMessage ? 'disabled' : '' }}>
                            Simpan Transaksi
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>