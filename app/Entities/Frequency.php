<?php

declare(strict_types=1);

namespace App\Entities;

final class Frequency
{
    public string $slug;
    public string $label;
    public int $installments; //indicates the required number of installments to fully pay given loans

    public static function make(string $slug, string $label, int $installments): self
    {
        $item = new self();
        $item->slug = $slug;
        $item->label = $label;
        $item->installments = $installments;

        return $item;
    }
}
