<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">
            Categories
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
            <button class=" bg-blue-600 text-2xl p-3 font-bold text-white rounded mb-6 mt-0"><a href="{{ route('pustakawan.category.create') }}">Add Category +</a></button>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-800 text-white uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Created_at</th>
                            <th scope="col" class="px-6 py-3">Updated_at</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                         @forelse ($categories as $category)
                            <tr class="hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-lg">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-lg">{{ $category->nama }}</td>
                                <td class="px-4 py-2 text-lg">{{ $category->created_at->format('j F Y') }}</td>
                                <td class="px-4 py-2 text-lg">{{ $category->updated_at->format('j F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-lg inline-flex items-center">
                                        <span><a href="{{ route('pustakawan.category.edit', $category) }}">Edit</a></span>
                                    </button>
                                    <form method="POST" action="{{ route('pustakawan.category.destroy', $category) }}" onsubmit="return confirm('Anda yakin ingin menghapus user ini?');">
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
                                <td colspan="7" class="text-center py-4">Tidak ada data user.</td>
                            </tr>
                        @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>