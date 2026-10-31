<?php

use App\Models\User;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
    $this->author = Author::factory()->create();
});

function validBookData(array $override = []): array
{
    return array_merge([
        'title' => 'Laskar Pelangi',
        'isbn' => '9786020312347',
        'publication_year' => 2005,
        'price' => 85000,
        'stock' => 3,
    ], $override);
}

it('menampilkan error validasi saat form buku kosong', function () {
    $this->post(route('books.store'), [])
        ->assertSessionHasErrors(['title', 'isbn', 'publication_year', 'price', 'stock', 'author_id']);
});

it('menolak ISBN dengan format salah', function () {
    $this->post(route('books.store'), validBookData(['isbn' => '12345', 'author_id' => $this->author->id]))
        ->assertSessionHasErrors('isbn');

    // 13 digit tetapi digit pemeriksa salah
    $this->post(route('books.store'), validBookData(['isbn' => '9786020312340', 'author_id' => $this->author->id]))
        ->assertSessionHasErrors('isbn');
});

it('menolak ISBN duplikat', function () {
    Book::factory()->create(['isbn' => '9786020312347']);

    $this->post(route('books.store'), validBookData(['author_id' => $this->author->id]))
        ->assertSessionHasErrors(['isbn' => 'ISBN sudah terdaftar.']);
});

it('menolak tahun terbit di luar rentang 1900 sampai tahun sekarang', function () {
    $this->post(route('books.store'), validBookData(['publication_year' => 1899, 'author_id' => $this->author->id]))
        ->assertSessionHasErrors('publication_year');

    $this->post(route('books.store'), validBookData(['publication_year' => now()->year + 1, 'author_id' => $this->author->id]))
        ->assertSessionHasErrors('publication_year');
});

it('menolak harga dan stok negatif', function () {
    $this->post(route('books.store'), validBookData(['price' => -1, 'stock' => -1, 'author_id' => $this->author->id]))
        ->assertSessionHasErrors(['price' => 'Harga tidak boleh negatif.', 'stock' => 'Stok tidak boleh negatif.']);
});

it('menolak author_id yang tidak ada', function () {
    $this->post(route('books.store'), validBookData(['author_id' => 9999]))
        ->assertSessionHasErrors(['author_id' => 'Penulis yang dipilih tidak valid.']);
});

it('menyimpan buku yang valid dan membersihkan tanda hubung ISBN', function () {
    $this->post(route('books.store'), validBookData([
        'isbn' => '978-602-03-1234-7',
        'author_id' => $this->author->id,
    ]))->assertRedirect(route('books.index'))
        ->assertSessionHas('success', 'Buku berhasil ditambahkan.');

    $this->assertDatabaseHas('books', ['isbn' => '9786020312347', 'title' => 'Laskar Pelangi']);
});

it('menerima ISBN-10 yang valid', function () {
    $this->post(route('books.store'), validBookData(['isbn' => '0306406152', 'author_id' => $this->author->id]))
        ->assertSessionHasNoErrors();
});

it('boleh memperbarui buku dengan ISBN miliknya sendiri', function () {
    $book = Book::factory()->create(['author_id' => $this->author->id]);

    $this->put(route('books.update', $book), validBookData([
        'isbn' => $book->isbn,
        'title' => 'Judul Baru',
        'author_id' => $this->author->id,
    ]))->assertRedirect(route('books.index'))
        ->assertSessionHasNoErrors();

    expect($book->fresh()->title)->toBe('Judul Baru');
});

it('melempar BookNotAvailableException saat stok 0', function () {
    $book = Book::factory()->create(['stock' => 0, 'title' => 'Bumi']);

    $this->post(route('books.borrow', $book))
        ->assertRedirect(route('books.index'))
        ->assertSessionHas('error', "Buku 'Bumi' tidak tersedia untuk dipinjam karena stok habis.");

    expect($book->fresh()->stock)->toBe(0);
});

it('mengembalikan JSON 422 untuk BookNotAvailableException', function () {
    $book = Book::factory()->create(['stock' => 0]);

    $this->postJson(route('books.borrow', $book))
        ->assertStatus(422)
        ->assertJsonPath('error', 'book_not_available')
        ->assertJsonPath('details.stock', 0);
});

it('mengurangi stok saat buku dipinjam', function () {
    $book = Book::factory()->create(['stock' => 2]);

    $this->post(route('books.borrow', $book))
        ->assertRedirect(route('books.index'))
        ->assertSessionHas('success');

    expect($book->fresh()->stock)->toBe(1);
});
