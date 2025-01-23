<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterCompaniesRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;
use App\Services\CompanyFilterService;

class CompanyController extends Controller
{
    protected $companyFilterService;

    public function __construct(CompanyFilterService $companyFilterService)
    {
        $this->companyFilterService = $companyFilterService;
    }

    public function __invoke(FilterCompaniesRequest $request)
    {
        $companies = Cache::remember('companies_filtered', 60, function () {
            return Company::all();
        });

        $filteredCompanies = $this->companyFilterService->filter($companies, $request);

        return CompanyResource::collection($filteredCompanies);
    }
}
