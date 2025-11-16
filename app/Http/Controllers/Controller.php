<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function maskMobile(?string $phone): ?string
    {
        if ($phone === null) {
            return null;
        }

        $digitsOnly = preg_replace('/\D+/', '', $phone);

        if ($digitsOnly === null) {
            return $phone;
        }

        if (strlen($digitsOnly) === 11 && str_starts_with($digitsOnly, '1')) {
            return substr($digitsOnly, 0, 3).'****'.substr($digitsOnly, 7);
        }

        return $phone;
    }
}
