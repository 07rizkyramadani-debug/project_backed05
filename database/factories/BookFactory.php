<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authors\Models\Author;
use Modules\Books\Models\Book;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        // ISBN-13 valid acak: 978 + 9 digit + digit pemeriksa
        $base = '978' . fake()->unique()->numerify('#########');
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int) $base[$i] * ($i % 2 === 0 ? 1 : 3);
        }

        return [
            'author_id' => Author::factory(),
            'title' => fake()->sentence(3),
            'isbn' => $base . ((10 - $sum % 10) % 10),
            'publication_year' => fake()->numberBetween(1990, (int) date('Y')),
            'price' => fake()->randomFloat(2, 10000, 200000),
            'stock' => 5,
        ];
    }
}
