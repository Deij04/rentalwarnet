<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

new #[Layout('components.layouts.app')] class extends Component {
    public $user;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('nullable|string|min:8')]
    public $password = '';

    #[Validate('required|in:Admin,Penyewa')]
    public $role = '';

    /**
     * Inisialisasi komponen dengan data user yang akan diedit.
     *
     * @param int $id
     * @return void
     */
    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->getRoleNames()->first();
    }

    /**
     * Memperbarui data user.
     *
     * @return void
     */
    public function update()
    {
        // Menyesuaikan validasi email untuk mengabaikan email user saat ini
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:Admin,Penyewa',
        ]);

        // Memperbarui data user
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Hanya perbarui password jika diisi
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        // Memperbarui role
        $this->user->syncRoles([$this->role]);

        session()->flash('message', 'User berhasil diperbarui.');
        return redirect()->route('user.index');
    }
}; ?>

<div>
    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                <a href="{{ route('user.index') }}">
                    <flux:button>
                        Kembali
                    </flux:button>
                </a>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <form wire:submit="update" class="space-y-6">
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
                        <flux:input wire:model="password" label="Password (opsional)" type="password"
                            placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)" />
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
                            Update User
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>