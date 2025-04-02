<x-layouts.app :title="__('Dashboard')">
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Dashboard</h1>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300">Selamat datang, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid gap-6 md:grid-cols-4 mb-8">
            <!-- Kartu Jumlah User -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Jumlah User</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Jumlah Penyewa -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Jumlah Penyewa</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ \App\Models\Penyewa::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Jumlah Room -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Jumlah Room</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ \App\Models\Room::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Kartu Jumlah Transaksi -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Jumlah Transaksi</h3>
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-300">{{ \App\Models\Transaksi::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigasi Fitur -->
        <div class="grid gap-6 md:grid-cols-4 mb-8">
            <a href="{{ route('user.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 px-6 rounded-xl text-center shadow-md">
                Kelola User
            </a>
            <a href="{{ route('penyewa.index') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-6 rounded-xl text-center shadow-md">
                Kelola Penyewa
            </a>
            <a href="{{ route('room.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-4 px-6 rounded-xl text-center shadow-md">
                Kelola Room
            </a>
            <a href="{{ route('transaksi.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-4 px-6 rounded-xl text-center shadow-md">
                Kelola Transaksi
            </a>
        </div>

        <!-- Placeholder untuk Data Terbaru (Opsional) -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-md p-6 border border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Transaksi Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pengguna
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Penyewa
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Ruangan
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Transaksi::with(['user', 'penyewa.user', 'room'])->orderByDesc('created_at')->take(5)->get() as $transaksi)
                        <tr class="hover">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->penyewa->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->room->Nama_ruangan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($transaksi->date)->format('d-m-Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>