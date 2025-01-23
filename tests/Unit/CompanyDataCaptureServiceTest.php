<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CompanyDataCaptureService;
use App\Services\DataParserInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;

class CompanyDataCaptureServiceTest extends TestCase
{
    public function testCapture()
    {
        $html = '<html><body><div><div><div><main><div><div><div><table><tbody><tr><td>1</td><td>58</td><td>Petrobras</td><td>100</td><td>36,47</td><td>200</td><td>300</td><td>Oil</td></tr></tbody></table></div></div></div></main></div></div></div></body></html>';

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('get')->andReturn(new Response(200, [], $html));

        $parser = Mockery::mock(DataParserInterface::class);
        $parser->shouldReceive('parse')->with($html)->andReturn([
            [
                'brasil_position' => '1',
                'forbes_rank' => '58',
                'name' => 'Petrobras',
                'revenue' => '100',
                'profit' => 36.47,
                'assets' => '200',
                'market_value' => '300',
                'sector' => 'Oil',
            ],
        ]);

        $service = new CompanyDataCaptureService($client, $parser);
        $result = $service->capture();

        $this->assertCount(1, $result);
        $this->assertEquals('Petrobras', $result[0]['name']);
        $this->assertEquals(36.47, $result[0]['profit']);
    }
}
