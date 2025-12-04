<?php

namespace App\Queries\Stats;

use App\Models\Module;

class GetTotalModulesQuery
{
    public function get(): int
    {
        return Module::count();
    }
}
