<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_filter_greater()
    {
        // Criar uma empresa de exemplo
        $this->post('/api/filter-companies', [
            'rule' => 'greater',
            'billions' => 15,
        ])->assertStatus(200);
    }

    public function test_filter_smaller()
    {
        // Criar uma empresa de exemplo
        $this->post('/api/filter-companies', [
            'rule' => 'smaller',
            'billions' => 15,
        ])->assertStatus(200);
    }

    public function test_filter_between()
    {
        // Criar empresas de exemplo para testes
        \DB::table('companies')->insert([
            ['name' => 'Empresa A', 'profit' => 10.50, 'rank' => 1],
            ['name' => 'Empresa B', 'profit' => 15.00, 'rank' => 2],
            ['name' => 'Empresa C', 'profit' => 20.00, 'rank' => 3],
        ]);

        // Teste de filtragem entre 10 e 20 bilhões
        $response = $this->post('/api/filter-companies', [
            'rule' => 'between',
            'range' => [10, 20],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'company_name' => 'Empresa A',
                        'profit' => '10.50',
                        'rank' => 1,
                    ],
                    [
                        'company_name' => 'Empresa B',
                        'profit' => '15.00',
                        'rank' => 2,
                    ],
                    [
                        'company_name' => 'Empresa C',
                        'profit' => '20.00',
                        'rank' => 3,
                    ],
                ],
            ]);
    }

    public function test_invalid_rule()
    {
        $response = $this->postJson('/api/filter-companies', [
            'rule' => 'invalid_rule',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rule']);
    }

    public function test_missing_billions_for_comparisons()
    {
        $response = $this->postJson('/api/filter-companies', [
            'rule' => 'greater',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['billions']);
    }
}
