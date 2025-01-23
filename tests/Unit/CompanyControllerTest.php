<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CompanyController;
use App\Services\CompanyFilterService;
use App\Http\Requests\FilterCompaniesRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testFilterGreater()
    {
        $companyFilterService = new CompanyFilterService();
        $controller = new CompanyController($companyFilterService);

        $request = FilterCompaniesRequest::create('/filter-companies', 'POST', [
            'rule' => 'greater',
            'billions' => 10,
        ]);

        Cache::shouldReceive('remember')
            ->andReturn(collect([
                new Company(['profit' => 20]),
                new Company(['profit' => 5]),
            ]));

        $response = $controller($request);

        $this->assertCount(1, $response->collection);
        $this->assertEquals(20, $response->collection->first()->profit);
    }

    public function testFilterSmaller()
    {
        $companyFilterService = new CompanyFilterService();
        $controller = new CompanyController($companyFilterService);

        $request = FilterCompaniesRequest::create('/filter-companies', 'POST', [
            'rule' => 'smaller',
            'billions' => 10,
        ]);

        Cache::shouldReceive('remember')
            ->andReturn(collect([
                new Company(['profit' => 20]),
                new Company(['profit' => 5]),
            ]));

        $response = $controller($request);

        $this->assertCount(1, $response->collection);
        $this->assertEquals(5, $response->collection->first()->profit);
    }

    public function testFilterBetween()
    {
        $companyFilterService = new CompanyFilterService();
        $controller = new CompanyController($companyFilterService);

        $request = FilterCompaniesRequest::create('/filter-companies', 'POST', [
            'rule' => 'between',
            'range' => [10, 20],
        ]);

        Cache::shouldReceive('remember')
            ->andReturn(collect([
                new Company(['profit' => 20]),
                new Company(['profit' => 5]),
                new Company(['profit' => 15]),
            ]));

        $response = $controller($request);

        $this->assertCount(2, $response->collection);
        $this->assertEquals(20, $response->collection->first()->profit);
        $this->assertEquals(15, $response->collection->last()->profit);
    }
}
