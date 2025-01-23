<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;

class CompanyDataParser implements DataParserInterface
{
    public function parse(string $html): array
    {
        $crawler = new Crawler($html);
        $rows = $crawler->filter('html body div div div main div div div table tbody');

        $companiesData = [];
        $rows->each(function (Crawler $row, $index) use (&$companiesData) {
            $columns = $row->filter('tr td');
            for ($i = 0; $i < $columns->count(); $i += 8) {
                if (count($companiesData) <= 20) {
                    $profit = trim($columns->eq($i + 4)->text());
                    if (strpos($profit, 'milhões') !== false) {
                        $profit = floatval(str_replace(['milhões', ','], ['', '.'], $profit)) / 1000;
                    } else {
                        $profit = floatval(str_replace(',', '.', $profit));
                    }

                    $companiesData[] = [
                        'brasil_position' => trim($columns->eq($i)->text()),
                        'forbes_rank' => trim($columns->eq($i + 1)->text()),
                        'name' => trim($columns->eq($i + 2)->text()),
                        'revenue' => trim($columns->eq($i + 3)->text()),
                        'profit' => round($profit, 3),
                        'assets' => trim($columns->eq($i + 5)->text()),
                        'market_value' => trim($columns->eq($i + 6)->text()),
                        'sector' => trim($columns->eq($i + 7)->text()),
                    ];
                }
            }
        });

        return $companiesData;
    }
}
