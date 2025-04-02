<?php

use Livewire\Volt\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

new #[Layout('components.layouts.app')] class extends Component {
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8')]
    public $password = '';

    #[Validate('required|in:Admin,Penyewa')]
    public $role = '';

    
     
// Fungsi untuk membuat user baru.*
// @return void
public function create(){$this->validate();

        // Membuat user baru
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Menetapkan role ke user
        $user->assignRole($this->role);

        session()->flash('message', 'User berhasil ditambahkan.');
        return redirect()->route('user.index');
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Tambah User Baru</h1>
                <a href="{{ route('user.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <form wire:submit="create" class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <flux:input wire:model="name" label="Nama" required
                            placeholder="Masukkan nama user" />
                        @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <flux:input wire:model="email" label="Email" required type="email"
                            placeholder="Masukkan email user" />
                        @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <flux:input wire:model="password" label="Password" required type="password"
                            placeholder="Masukkan password (minimal 8 karakter)" />
                        @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <flux:select wire:model="role" label="Role" required>
                            <option value="">Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Penyewa">Penyewa</option>
                        </flux:select>
                        @error('role')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end gap-3">
                        <flux:button type="submit" variant="primary">
                            Simpan User
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>