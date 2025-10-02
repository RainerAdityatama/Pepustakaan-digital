<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

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

                    <form method="POST" action="{{ route('pustakawan.books.update', $book->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200">
                                <option value="">Choose a Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Nama Category" required>
                        </div>

                        <div class="mb-4">
                            <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Nama Author" required>
                        </div>

                        <div class="mb-4">
                            <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publisher</label>
                            <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Nama Publisher" required>
                        </div>

                        <div class="mb-4">
                            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
                            <input type="text" name="year" id="year" value="{{ old('year', $book->year) }}" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Tahun Terbit" required>
                        </div>

                        <label for="year" class="mb-4 block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Sebelumnya</label>
                        @if ($book->file_path)
                        <img src="{{ asset('storage/' . $book->file_path) }}" style="width: 100px;" alt="Current Image" class="w-40 h-auto rounded-md object-cover my-3">
                        @endif

                        <div class="mb-4 mt-4">
                            <label for="file_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">File Path</label>
                            <input type="file" name="file_path" id="file_path" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Tahun Terbit">
                        </div>

                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah stock yang tersedia</label>
                        <div class="mb-4 flex items-center space-x-3">
                            <input type="number" name="stock" id="stock" value="{{ $book->stock->count() }}" class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-200" placeholder="Masukan Jumlah Stok" readonly>
                            <a href="{{ route('pustakawan.stocks.manage', $book->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-base font-medium whitespace-nowrap">
                            Kelola Stok
                            </a>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>