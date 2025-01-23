<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface CompanyFilterServiceInterface
{
    public function filter(Collection $companies, $request): Collection;
}
