<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Management Denda') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">
            Management Denda
        </h1>

              @if (session('success'))
                <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-300 rounded p-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

        <div class="flex justify-center">
            <button class=" bg-blue-600 text-2xl p-3 font-bold text-white rounded mb-6 mt-0"><a href="{{ route('pustakawan.denda.create') }}">Add Denda +</a></button>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode Peminjaman</th>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Jumlah Denda</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                         @forelse ($dendas as $denda)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 text-lg">{{ $denda->peminjaman_id }}</td>
                                <td class="px-6 py-4 text-lg">{{ $denda->peminjaman->user->name }}</td>
                                <td class="px-6 py-4 text-lg">Rp{{ number_format($denda->jumlah_denda, 0, ',', '.') }}</td>
                                @if ($denda->status == 'lunas')
                                    <td class="px-6 py-4 text-lg">Lunas</td>
                                @else
                                    <td class="px-6 py-4 text-lg">Belum Lunas</td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-lg inline-flex items-center">
                                            <span><a href="{{ route('pustakawan.denda.edit', $denda) }}">Edit</a></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                         @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Tidak ada data denda.</td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>