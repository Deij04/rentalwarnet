<?php

use Livewire\Volt\Component;
use App\Models\Penyewa;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

new #[Layout('components.layouts.app')] class extends Component {
    #[Validate('required|exists:users,id')]
    public $user_id = '';

    #[Validate('required|integer|min:1|max:150')]
    public $umur = '';

    #[Validate('required|string|max:255')]
    public $alamat = '';

    #[Validate('required|in:Laki Laki,Perempuan')]
    public $jenis_kelamin = '';

    public $searchUser = '';
    public $users = [];
    public $showUserDropdown = false;

    public function mount()
    {
        $this->users = [];
    }

    public function updatedSearchUser($value)
    {
        if (strlen($value) >= 2) { // Mulai mencari setelah minimal 2 karakter
            $this->users = User::where('name', 'like', '%' . $value . '%')->take(5)->get()->toArray();
            $this->showUserDropdown = true;
        } else {
            $this->users = [];
            $this->showUserDropdown = false;
        }
    }

    public function selectUser($userId, $userName)
    {
        $this->user_id = $userId;
        $this->searchUser = $userName;
        $this->showUserDropdown = false;
    }

    public function create()
    {
        $this->validate();

        Penyewa::create([
            'user_id' => $this->user_id,
            'Umur' => $this->umur,
            'Alamat' => $this->alamat,
            'Jenis Kelamin' => $this->jenis_kelamin,
        ]);

        session()->flash('message', 'Data penyewa berhasil ditambahkan.');
        return redirect()->route('penyewa.index');
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Tambah Penyewa Baru</h1>
                <a href="{{ route('penyewa.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <form wire:submit="create" class="space-y-6">
                    <!-- User Search -->
                    <div x-data="{ open: false }" @click.away="open = false">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            Pengguna
                        </label>
                        <div class="relative">
                            <input type="text" wire:model.live="searchUser" @focus="open = true"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-zinc-900 dark:border-zinc-700 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                placeholder="Ketik nama pengguna..." required />
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div x-show="open && $wire.showUserDropdown" class="absolute z-10 mt-1 w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md shadow-lg max-h-60 overflow-auto">
                                @forelse ($users as $user)
                                    <div wire:key="user-{{ $user['id'] }}"
                                        @click="$wire.selectUser({{ $user['id'] }}, '{{ $user['name'] }}'); open = false"
                                        class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700 cursor-pointer">
                                        {{ $user['name'] }}
                                    </div>
                                @empty
                                    <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada pengguna ditemukan.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Umur -->
                    <div>
                        <flux:input wire:model="umur" label="Umur" type="number" required
                            placeholder="Masukkan umur penyewa" />
                        @error('umur')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <flux:textarea wire:model="alamat" label="Alamat" required
                            placeholder="Masukkan alamat penyewa" rows="3" />
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <flux:select wire:model="jenis_kelamin" label="Jenis Kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki Laki">Laki Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </flux:select>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end gap-3">
                        <flux:button type="submit" variant="primary">
                            Simpan Penyewa
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>