<?php

namespace App\Transformer;

interface TransformerInterface
{
    public function arrayToEntity(array $data): object;
}