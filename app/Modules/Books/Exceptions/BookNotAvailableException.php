<?php

namespace Modules\Books\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class BookNotAvailableException extends Exception
{
    public function __construct(
        protected string $bookTitle,
        protected int $stock = 0,
    ) {
        parent::__construct(
            "Buku '{$bookTitle}' tidak tersedia untuk dipinjam karena stok habis."
        );
    }

    public function getBookTitle(): string
    {
        return $this->bookTitle;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    /** Nilai plus: catat ke storage/logs/laravel.log. */
    public function report(): bool
    {
        Log::warning($this->getMessage(), [
            'exception' => static::class,
            'book' => $this->bookTitle,
            'stock' => $this->stock,
        ]);

        return true;
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
                'error' => 'book_not_available',
                'details' => [
                    'book' => $this->bookTitle,
                    'stock' => $this->stock,
                ],
            ], 422);
        }

        return redirect()
            ->route('books.index')
            ->with('error', $this->getMessage());
    }
}


