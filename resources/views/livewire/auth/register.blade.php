<?php

use App\Models\User;
use App\Models\Penyewa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $Umur = ''; // Sesuaikan dengan nama kolom di migrasi
    public string $Alamat = ''; // Sesuaikan dengan nama kolom di migrasi
    public string $Jenis_Kelamin = ''; // Sesuaikan dengan nama kolom di migrasi

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'Umur' => ['required', 'integer', 'min:1', 'max:150'],
            'Alamat' => ['required', 'string', 'max:255'],
            'Jenis_Kelamin' => ['required', 'in:Laki Laki,Perempuan'], // Sesuaikan dengan nilai enum di migrasi
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])));

        //simpan data ke tabel user
        
        // Simpan data ke tabel penyewa
        Penyewa::create([
            'user_id' => $user->id,
            'Umur' => $validated['Umur'],
            'Alamat' => $validated['Alamat'],
            'Jenis Kelamin' => $validated['Jenis_Kelamin'],
        ]);

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Umur -->
        <flux:input
            wire:model="Umur"
            :label="__('Umur')"
            type="number"
            required
            autocomplete="off"
            :placeholder="__('Masukkan umur Anda')"
        />
        @error('Umur') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Alamat -->
        <flux:textarea
            wire:model="Alamat"
            :label="__('Alamat')"
            required
            autocomplete="street-address"
            :placeholder="__('Masukkan alamat Anda')"
            rows="4"
        />
        @error('Alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Jenis Kelamin -->
        <flux:select
            wire:model="Jenis_Kelamin"
            :label="__('Jenis Kelamin')"
            required
        >
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki Laki">Laki Laki</option> <!-- Sesuaikan dengan nilai enum di migrasi -->
            <option value="Perempuan">Perempuan</option>
        </flux:select>
        @error('Jenis_Kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
        />
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
        />
        @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>