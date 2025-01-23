<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterCompaniesRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;
use App\Services\CompanyFilterServiceInterface;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    protected $companyFilterService;

    public function __construct(CompanyFilterServiceInterface $companyFilterService)
    {
        $this->companyFilterService = $companyFilterService;
    }

    public function __invoke(FilterCompaniesRequest $request)
    {
        Log::info('Received request to filter companies', ['request' => $request->all()]);

        $companies = Cache::remember('companies_filtered', 60, function () {
            Log::info('Fetching companies from database');
            return Company::all();
        });

        Log::info('Filtering companies', ['companies_count' => $companies->count()]);

        $filteredCompanies = $this->companyFilterService->filter($companies, $request);

        Log::info('Filtered companies', ['filtered_count' => $filteredCompanies->count()]);

        return CompanyResource::collection($filteredCompanies);
    }
}
