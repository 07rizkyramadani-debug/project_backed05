<?php

namespace Modules\Authors\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class AuthorHasBooksException extends Exception
{
    public function __construct(
        protected string $authorName,
        protected int $bookCount,
    ) {
        parent::__construct(
            "Penulis '{$authorName}' tidak dapat dihapus karena masih memiliki {$bookCount} buku."
        );
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    /** Nilai plus: catat ke storage/logs/laravel.log. */
    public function report(): bool
    {
        Log::warning($this->getMessage(), [
            'exception' => static::class,
            'author' => $this->authorName,
            'book_count' => $this->bookCount,
        ]);

        // true = hentikan pelaporan default agar tidak tercatat dua kali
        return true;
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
                'error' => 'author_has_books',
                'details' => [
                    'author' => $this->authorName,
                    'book_count' => $this->bookCount,
                ],
            ], 422);
        }

        return redirect()
            ->route('authors.index')
            ->with('error', $this->getMessage());
    }
}


