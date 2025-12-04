<?php

namespace App\Queries\Stats;

use App\Models\User;

class GetTotalStudentsQuery
{
    public function get(): int
    {
        return User::student()->count();
    }
}
