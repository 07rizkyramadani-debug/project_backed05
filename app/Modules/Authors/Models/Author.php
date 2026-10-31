<?php

namespace Modules\Authors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Books\Models\Book;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'bio'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    protected static function newFactory(): Factory
    {
        return AuthorFactory::new();
    }
}
