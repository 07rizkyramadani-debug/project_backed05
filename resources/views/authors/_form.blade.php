@php($author = $author ?? null)

<div>
    <x-input-label for="name" value="Nama Penulis" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
        :value="old('name', $author?->name)" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="email" value="Email" />
    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
        :value="old('email', $author?->email)" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-input-label for="bio" value="Bio" />
    <textarea id="bio" name="bio" rows="4"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('bio', $author?->bio) }}</textarea>
    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
</div>
