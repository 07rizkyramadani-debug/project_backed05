<?php

namespace Modules\Books\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validasi format ISBN-10 atau ISBN-13 (termasuk digit pemeriksa).
 * Nilai diharapkan sudah dibersihkan dari tanda hubung dan spasi.
 */
class ValidIsbn implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isbn = (string) $value;

        $valid = match (strlen($isbn)) {
            10 => $this->isValidIsbn10($isbn),
            13 => $this->isValidIsbn13($isbn),
            default => false,
        };

        if (! $valid) {
            $fail('Format ISBN tidak valid (gunakan ISBN-10 atau ISBN-13 yang benar).');
        }
    }

    private function isValidIsbn10(string $isbn): bool
    {
        if (! preg_match('/^\d{9}[\dX]$/', $isbn)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $digit = $isbn[$i] === 'X' ? 10 : (int) $isbn[$i];
            $sum += $digit * (10 - $i);
        }

        return $sum % 11 === 0;
    }

    private function isValidIsbn13(string $isbn): bool
    {
        if (! preg_match('/^\d{13}$/', $isbn)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += (int) $isbn[$i] * ($i % 2 === 0 ? 1 : 3);
        }

        return $sum % 10 === 0;
    }
}

