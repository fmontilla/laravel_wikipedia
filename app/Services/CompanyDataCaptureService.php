<?php

namespace App\Services;

use GuzzleHttp\Client;

class CompanyDataCaptureService implements DataCaptureServiceInterface
{
    protected $client;
    protected $parser;

    public function __construct(Client $client, DataParserInterface $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    public function capture(): array
    {
        $url = 'https://pt.wikipedia.org/wiki/Lista_das_maiores_empresas_do_Brasil';
        $response = $this->client->get($url);
        $html = (string) $response->getBody();

        return $this->parser->parse($html);
    }
}
