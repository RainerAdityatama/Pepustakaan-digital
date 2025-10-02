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

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 p-4">

                @forelse ($books as $book)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-2 flex flex-col overflow-hidden group">
                        <div class="relative overflow-hidden h-56">
                            <img class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-110" 
                                src="{{ asset('storage/'.$book->file_path) }}" 
                                alt="Cover buku {{ $book->title }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <div class="absolute bottom-0 left-0 p-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                <span class="inline-block bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">{{ $book->category->nama }}</span>
                            </div>
                        </div>
                        
                        <div class="p-5 flex-grow">
                            <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $book->title }}</h3>
                            <p class="text-gray-700 text-sm mb-1"><strong>Penulis:</strong> {{ $book->author }}</p>
                            <p class="text-gray-700 text-sm mb-1"><strong>Penerbit:</strong> {{ $book->publisher }}</p>
                            <p class="text-gray-700 text-sm"><strong>Tahun:</strong> {{ $book->year }}</p>
                        </div>

                        <div class="border-t border-gray-100 px-5 py-3 bg-gray-50 flex justify-between items-center text-sm">
                            <div class="text-gray-800 font-semibold flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7V4c0-1.105 3.582-2 8-2s8 .895 8 2v3m0 0v10c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                Stok: <span class="ml-1 text-base">{{ $book->stock->count() }}</span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('user.books_user.pinjam', $book) }}">
                                    @csrf
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1.5 px-4 rounded-lg text-sm inline-flex items-center transition duration-200">
                                        Pinjam
                                    </button>
                            </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white rounded-lg shadow-md">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.208 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.792 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.792 5 16.5 5c1.708 0 3.332.477 4.5 1.253v13C19.832 18.477 18.208 18 16.5 18c-1.708 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="mt-4 text-xl font-semibold text-gray-600">Tidak ada data buku yang ditemukan.</p>
                        <p class="mt-2 text-gray-500">Mungkin Anda bisa menambahkan buku baru?</p>
                    </div>
                @endforelse

            </div>
    </div>

</x-app-layout>