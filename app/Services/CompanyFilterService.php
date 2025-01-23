<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CompanyFilterService implements CompanyFilterServiceInterface
{
    public function filter(Collection $companies, $request): Collection
    {
        Log::info('Applying filter', ['rule' => $request->rule]);

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
        Log::info('Filtering companies with profit greater than', ['billions' => $billions]);

        return $companies->filter(function ($company) use ($billions) {
            return $company->profit > $billions;
        });
    }

    private function filterSmaller(Collection $companies, $billions): Collection
    {
        Log::info('Filtering companies with profit smaller than', ['billions' => $billions]);

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

        Log::info('Filtering companies with profit between', ['min' => $min, 'max' => $max]);

        return $companies->filter(function ($company) use ($min, $max) {
            return $company->profit >= $min && $company->profit <= $max;
        });
    }
}
