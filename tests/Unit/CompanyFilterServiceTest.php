<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CompanyFilterService;
use Illuminate\Support\Collection;
use App\Models\Company;

class CompanyFilterServiceTest extends TestCase
{
    public function testFilterGreater()
    {
        $service = new CompanyFilterService();
        $companies = collect([
            new Company(['profit' => 20]),
            new Company(['profit' => 5]),
        ]);

        $request = new \stdClass();
        $request->rule = 'greater';
        $request->billions = 10;

        $filtered = $service->filter($companies, $request);

        $this->assertCount(1, $filtered);
        $this->assertEquals(20, $filtered->first()->profit);
    }

    public function testFilterSmaller()
    {
        $service = new CompanyFilterService();
        $companies = collect([
            new Company(['profit' => 20]),
            new Company(['profit' => 5]),
        ]);

        $request = new \stdClass();
        $request->rule = 'smaller';
        $request->billions = 10;

        $filtered = $service->filter($companies, $request);

        $this->assertCount(1, $filtered);
        $this->assertEquals(5, $filtered->first()->profit);
    }

    public function testFilterBetween()
    {
        $service = new CompanyFilterService();
        $companies = collect([
            new Company(['profit' => 20]),
            new Company(['profit' => 5]),
            new Company(['profit' => 15]),
        ]);

        $request = new \stdClass();
        $request->rule = 'between';
        $request->range = [10, 20];

        $filtered = $service->filter($companies, $request);

        $this->assertCount(2, $filtered);
        $this->assertEquals(20, $filtered->first()->profit);
        $this->assertEquals(15, $filtered->last()->profit);
    }
}
