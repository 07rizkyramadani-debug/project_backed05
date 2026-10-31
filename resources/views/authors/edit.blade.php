<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Penulis') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('authors.update', $author) }}" class="space-y-6" novalidate>
                    @csrf
                    @method('PUT')
                    @include('authors._form', ['author' => $author])
                    <div class="flex items-center gap-4">
                        <x-primary-button>Perbarui</x-primary-button>
                        <a href="{{ route('authors.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
