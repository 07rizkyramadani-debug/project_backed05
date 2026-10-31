<?php

namespace Modules\Books\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Authors\Models\Author;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'isbn',
        'publication_year',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'publication_year' => 'integer',
        'stock' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    protected static function newFactory(): Factory
    {
        return BookFactory::new();
    }
}

