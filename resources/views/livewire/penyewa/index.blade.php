<?php

use Livewire\Volt\Component;
use App\Models\penyewa;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.app')] class extends Component {
    public $penyewas;
    public $search = '';

    public function mount()
    {
        $this->refreshPenyewas();
    }

    public function refreshPenyewas()
    {
        $query = penyewa::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('Umur', 'like', '%' . $this->search . '%')
                  ->orWhere('Alamat', 'like', '%' . $this->search . '%')
                  ->orWhere('Jenis Kelamin', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $this->penyewas = $query->with(['user'])->get();
    }

    public function updated($property)
    {
        if (in_array($property, ['search'])) {
            $this->refreshPenyewas();
        }
    }

    public function delete($id)
    {
        $penyewa = penyewa::find($id);

        if ($penyewa) {
            $penyewa->delete();
            session()->flash('message', 'Data penyewa berhasil dihapus.');
        }

        $this->refreshPenyewas();
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Penyewa</h1>
            <a href="{{ route('penyewa.create') }}">
                <flux:button variant="primary">
                    Tambah Penyewa
                </flux:button>
            </a>
        </div>

        @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-4"
            role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        </div>
        @endif

        <!-- Filter dan Pencarian -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-200">
                    Pencarian Penyewa
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-zinc-900 dark:border-zinc-700 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                        placeholder="Cari berdasarkan nama, umur, alamat, atau jenis kelamin..." />
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Pengguna
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Umur
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alamat
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis Kelamin
                        </th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyewas as $penyewa)
                    <tr class="hover">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $penyewa->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $penyewa->Umur }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $penyewa->Alamat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $penyewa->{'Jenis Kelamin'} }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ route('penyewa.edit', $penyewa->id) }}">
                                <flux:button variant="filled">
                                    Edit
                                </flux:button>
                            </a>
                            <flux:button variant="danger" wire:click="delete({{ $penyewa->id }})"
                                wire:confirm="Apakah Anda yakin ingin menghapus penyewa ini?">
                                Hapus
                            </flux:button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>