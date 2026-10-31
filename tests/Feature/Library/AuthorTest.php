<?php

use App\Models\User;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('menolak tamu yang belum login', function () {
    auth()->logout();

    $this->get(route('authors.index'))->assertRedirect(route('login'));
});

it('menampilkan error validasi saat form penulis kosong', function () {
    $this->post(route('authors.store'), [])
        ->assertSessionHasErrors(['name', 'email']);
});

it('memakai pesan error Bahasa Indonesia', function () {
    $this->post(route('authors.store'), [])
        ->assertSessionHasErrors([
            'name' => 'Nama penulis wajib diisi.',
            'email' => 'Email penulis wajib diisi.',
        ]);
});

it('menolak email tidak valid', function () {
    $this->post(route('authors.store'), ['name' => 'Budi', 'email' => 'bukan-email'])
        ->assertSessionHasErrors(['email' => 'Format email tidak valid.']);
});

it('menolak email duplikat', function () {
    Author::factory()->create(['email' => 'budi@example.com']);

    $this->post(route('authors.store'), ['name' => 'Budi 2', 'email' => 'budi@example.com'])
        ->assertSessionHasErrors(['email' => 'Email sudah digunakan penulis lain.']);
});

it('menolak bio lebih dari 1000 karakter', function () {
    $this->post(route('authors.store'), [
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'bio' => str_repeat('a', 1001),
    ])->assertSessionHasErrors(['bio']);
});

it('menyimpan penulis yang valid', function () {
    $this->post(route('authors.store'), [
        'name' => 'Andrea Hirata',
        'email' => 'andrea@example.com',
        'bio' => 'Penulis Laskar Pelangi.',
    ])->assertRedirect(route('authors.index'))
        ->assertSessionHas('success', 'Penulis berhasil ditambahkan.');

    $this->assertDatabaseHas('authors', ['email' => 'andrea@example.com']);
});

it('boleh memperbarui penulis dengan email miliknya sendiri', function () {
    $author = Author::factory()->create(['email' => 'lama@example.com']);

    $this->put(route('authors.update', $author), [
        'name' => 'Nama Baru',
        'email' => 'lama@example.com',
    ])->assertRedirect(route('authors.index'))
        ->assertSessionHasNoErrors();

    expect($author->fresh()->name)->toBe('Nama Baru');
});

it('melempar AuthorHasBooksException saat menghapus penulis yang punya buku', function () {
    $author = Author::factory()->create(['name' => 'Tere Liye']);
    Book::factory()->create(['author_id' => $author->id]);

    $this->delete(route('authors.destroy', $author))
        ->assertRedirect(route('authors.index'))
        ->assertSessionHas('error', "Penulis 'Tere Liye' tidak dapat dihapus karena masih memiliki 1 buku.");

    $this->assertDatabaseHas('authors', ['id' => $author->id]);
});

it('mengembalikan JSON 422 untuk AuthorHasBooksException', function () {
    $author = Author::factory()->create();
    Book::factory()->create(['author_id' => $author->id]);

    $this->deleteJson(route('authors.destroy', $author))
        ->assertStatus(422)
        ->assertJsonPath('error', 'author_has_books')
        ->assertJsonPath('details.book_count', 1);
});

it('menghapus penulis yang tidak punya buku', function () {
    $author = Author::factory()->create();

    $this->delete(route('authors.destroy', $author))
        ->assertRedirect(route('authors.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('authors', ['id' => $author->id]);
});
