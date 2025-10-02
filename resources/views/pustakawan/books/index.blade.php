<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">
            Books
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
            <button class=" bg-blue-600 text-2xl p-3 font-bold text-white rounded mb-6 mt-0"><a href="{{ route('pustakawan.books.create') }}">Add Books +</a></button>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Author</th>
                            <th scope="col" class="px-6 py-3">Publisher</th>
                            <th scope="col" class="px-6 py-3">Year</th>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Stock</th>
                            <th scope="col" class="px-6 py-3">Created_at</th>
                            <th scope="col" class="px-6 py-3">Updated_at</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                         @forelse ($books as $book)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-lg">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-lg">{{ $book->category->nama }}</td>
                                <td class="px-6 py-4 text-lg">{{ $book->title }}</td>
                                <td class="px-6 py-4 text-lg">{{ $book->author }}</td>
                                <td class="px-6 py-4 text-lg">{{ $book->publisher }}</td>
                                <td class="px-6 py-4 text-lg">{{ $book->year }}</td>
                                <td class="px-6 py-4 text-lg"><img src="{{ asset('storage/'.$book->file_path) }}" alt="gambar buku {{ $book->title }}"></a></td>
                                <td class="px-6 py-4 text-lg">{{ $book->stock->count()}}</td>
                                <td class="px-4 py-2 text-lg">{{ $book->created_at->format('j F Y') }}</td>
                                <td class="px-4 py-2 text-lg">{{ $book->updated_at->format('j F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-lg inline-flex items-center">
                                        <span><a href="{{ route('pustakawan.books.edit', $book) }}">Edit</a></span>
                                    </button>
                                    <form method="POST" action="{{ route('pustakawan.books.destroy', $book) }}" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-lg inline-flex items-center">
                                            Hapus
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                         @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">Tidak ada data user.</td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>