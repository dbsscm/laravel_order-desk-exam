<?php

namespace App\Support;

class Money
{
    /**
     * Prices are stored as whole cents to avoid rounding differences
     * between database engines.
     */
    public static function format(int $cents): string
    {
        return '₱'.number_format($cents / 100, 2);
    }
}
