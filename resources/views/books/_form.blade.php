@php($book = $book ?? null)

<div>
    <x-input-label for="title" value="Judul Buku" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
        :value="old('title', $book?->title)" autofocus />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <x-input-label for="isbn" value="ISBN (10 atau 13 digit)" />
    <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
        :value="old('isbn', $book?->isbn)" />
    <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
</div>

<div>
    <x-input-label for="author_id" value="Penulis" />
    <select id="author_id" name="author_id"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">-- Pilih penulis --</option>
        @foreach ($authors as $author)
            <option value="{{ $author->id }}" @selected((string) old('author_id',
            $book?->author_id) === (string) $author->id)>
                {{ $author->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="publication_year" value="Tahun Terbit" />
    <x-text-input id="publication_year" name="publication_year" type="number" class="mt-1 block w-full"
        :value="old('publication_year', $book?->publication_year)" />
    <x-input-error :messages="$errors->get('publication_year')" class="mt-2" />
</div>

<div>
    <x-input-label for="price" value="Harga" />
    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
        :value="old('price', $book?->price)" />
    <x-input-error :messages="$errors->get('price')" class="mt-2" />
</div>

<div>
    <x-input-label for="stock" value="Stok" />
    <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
        :value="old('stock', $book?->stock)" />
    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
</div>


