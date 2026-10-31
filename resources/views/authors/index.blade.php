<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;justify-content:space-between;align-items:center;" class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daftar Penulis') }}</h2>
            <a href="{{ route('authors.create') }}" class="btn-tambah">+ Tambah Penulis</a>
        </div>
    </x-slot>

    <x-action-styles />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left">Nama</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-center">Jumlah Buku</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse ($authors as $index => $author)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6">{{ $authors->firstItem() + $index }}</td>
                                    <td class="py-3 px-6">{{ $author->name }}</td>
                                    <td class="py-3 px-6">{{ $author->email }}</td>
                                    <td class="py-3 px-6 text-center">{{ $author->books_count }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="aksi-group">
                                            <a href="{{ route('authors.edit', $author) }}" class="btn-aksi btn-edit">Edit</a>
                                            <form action="{{ route('authors.destroy', $author) }}" method="POST"
                                                onsubmit="return confirm('Hapus penulis ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                        Belum ada data penulis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $authors->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>