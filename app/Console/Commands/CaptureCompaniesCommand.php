<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\DataCaptureServiceInterface;

class CaptureCompaniesCommand extends Command
{
    protected $signature = 'companies:capture';
    protected $description = 'Capture companies data from Wikipedia';

    protected $dataCaptureService;

    public function __construct(DataCaptureServiceInterface $dataCaptureService)
    {
        parent::__construct();
        $this->dataCaptureService = $dataCaptureService;
    }

    public function handle()
    {
        $companiesData = $this->dataCaptureService->capture();

        foreach ($companiesData as $data) {
            DB::table('companies')->updateOrInsert(
                [
                    'name' => $data['name'],
                    'profit' => $data['profit'],
                    'rank' => $data['forbes_rank'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->info('Companies data captured successfully.');
    }
}
