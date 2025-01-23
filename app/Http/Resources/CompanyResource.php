<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'company_name' => $this->name,
            'profit' => number_format($this->profit, 3),
            'rank' => $this->rank,
        ];
    }
}
