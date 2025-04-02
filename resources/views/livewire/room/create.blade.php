<?php

use Livewire\Volt\Component;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Database\QueryException;

new #[Layout('components.layouts.app')] class extends Component {
    #[Validate('required|string|max:255')]
    public $nama_ruangan = '';

    #[Validate('required|numeric|min:0|max:999999999999.99')]
    public $harga_sewa = '';

    public function create()
    {
        $this->validate();
        
        try {
            Room::create([
                'Nama_ruangan' => $this->nama_ruangan,
                'Harga_sewa' => $this->harga_sewa,
            ]);
            
            session()->flash('message', 'Data ruangan berhasil ditambahkan.');
            return redirect()->route('room.index');
        } catch (QueryException $e) {
            session()->flash('error', 'Harga yang dimasukkan melebihi batas yang diperbolehkan.');
        }
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Tambah Ruangan Baru</h1>
                <a href="{{ route('room.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                @if (session('error'))
                    <p class="mt-1 text-sm text-red-500">{{ session('error') }}</p>
                @endif
                
                <form wire:submit="create" class="space-y-6">
                    <!-- Nama Ruangan -->
                    <div>
                        <flux:input wire:model="nama_ruangan" label="Nama Ruangan" required
                            placeholder="Masukkan nama ruangan" />
                        @error('nama_ruangan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Sewa -->
                    <div>
                        <flux:input wire:model="harga_sewa" label="Harga Sewa" type="number" step="0.01" min="0" max="999999999999.99" required
                            placeholder="Masukkan harga sewa ruangan" />
                        @error('harga_sewa')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end gap-3">
                        <flux:button type="submit" variant="primary">
                            Simpan Ruangan
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
