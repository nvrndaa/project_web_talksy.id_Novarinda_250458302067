<?php

namespace App\Queries\Stats;

use App\Models\Certificate;

class GetTotalCertificatesQuery
{
    public function get(): int
    {
        return Certificate::count();
    }
}
