<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CompanyFilterService implements CompanyFilterServiceInterface
{
    public function filter(Collection $companies, $request): Collection
    {
        switch ($request->rule) {
            case 'greater':
                return $this->filterGreater($companies, $request->billions);
            case 'smaller':
                return $this->filterSmaller($companies, $request->billions);
            case 'between':
                return $this->filterBetween($companies, $request->range);
            default:
                return collect();
        }
    }

    private function filterGreater(Collection $companies, $billions): Collection
    {
        return $companies->filter(function ($company) use ($billions) {
            return $company->profit > $billions;
        });
    }

    private function filterSmaller(Collection $companies, $billions): Collection
    {
        return $companies->filter(function ($company) use ($billions) {
            return $company->profit < $billions;
        });
    }

    private function filterBetween(Collection $companies, $range): Collection
    {
        if (!$range || count($range) !== 2) {
            return collect();
        }
        $min = $range[0];
        $max = $range[1];

        return $companies->filter(function ($company) use ($min, $max) {
            return $company->profit >= $min && $company->profit <= $max;
        });
    }
}
