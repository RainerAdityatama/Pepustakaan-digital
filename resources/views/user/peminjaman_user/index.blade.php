<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peminjaman') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">
            Peminjaman
        </h1>

              @if (session('success'))
                <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-300 rounded p-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode Peminjaman</th>
                            <th scope="col" class="px-6 py-3">Kode Buku</th>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Buku</th>
                            <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pengembalian Seharusnya</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                         @forelse ($peminjamans as $peminjaman)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-lg">{{ $peminjaman->id }}</td>
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->stock_id }}</td>
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->user->name }}</td>
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->book->title }}</td>
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->tanggal_peminjaman }}</td>
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->tanggal_pengembalian_seharusnya }}</td>
                                @if ($peminjaman->tanggal_pengembalian == NULL)
                                <td class="px-6 py-4 text-lg">BELUM MENGEMBALIKAN</td>
                                @else
                                <td class="px-6 py-4 text-lg">{{ $peminjaman->tanggal_pengembalian }}</td>
                                @endif
                                <td class="px-4 py-2 text-lg">{{ $peminjaman->status }}</td>
                                @if ($peminjaman->tanggal_pengembalian == NULL)
                                <td class="px-6 py-4 text-lg">-</td>
                                @else
                                <td class="px-4 py-2 text-lg">Rp{{ number_format($peminjaman->denda, 0, ',', '.') }}</td>
                                @endif
                            </tr>
                         @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">Tidak ada data peminjaman.</td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>