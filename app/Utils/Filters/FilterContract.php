<?php


namespace App\Utils\Filters;

interface FilterContract
{
    public function handle($value = null): void;
}
