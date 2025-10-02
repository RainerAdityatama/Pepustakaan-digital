<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Kelola Stok untuk Buku : <span class="underline">{{ $book->title }}</span>
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 rounded p-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium">Daftar Stok Saat Ini</h3>
                            <p class="text-gray-600">Total Stok Tersedia: {{ $book->stock->count() }} unit</p>
                        </div>
                        {{-- Tombol untuk menambah stok --}}
                        <form action="{{ route('pustakawan.stocks.add', ['book' => $book->id]) }}" method="POST">
                            @csrf
                            <div class="flex gap-4">
                                <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required min="0"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                                    Tambah Stok
                                </button>
                            </div>    
                        </form>
                    </div>
                </div>

                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($book->stock as $stock)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $stock->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stock->status }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stock->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Tombol untuk menghapustakawan stok --}}
                                        <form action="{{ route('pustakawan.stocks.remove', $stock->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapustakawan stok ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada stok untuk buku ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                 <div class="p-6 bg-gray-50 border-t">
                    <a href="{{ route('pustakawan.books.edit', $book->id) }}" class="text-blue-600 hover:underline">
                        &larr; Kembali ke halaman edit buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>