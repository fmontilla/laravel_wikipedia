<?php

namespace App\Services;

interface DataParserInterface
{
    public function parse(string $html): array;
}
