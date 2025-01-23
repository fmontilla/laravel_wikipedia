<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CompanyDataParser;

class CompanyDataParserTest extends TestCase
{
    public function testParse()
    {
        $html = '<html><body><div><div><div><main><div><div><div><table><tbody><tr><td>1</td><td>58</td><td>Petrobras</td><td>100</td><td>36,47</td><td>200</td><td>300</td><td>Oil</td></tr></tbody></table></div></div></div></main></div></div></div></body></html>';

        $parser = new CompanyDataParser();
        $result = $parser->parse($html);

        $this->assertCount(1, $result);
        $this->assertEquals('Petrobras', $result[0]['name']);
        $this->assertEquals(36.47, $result[0]['profit']);
    }
}
