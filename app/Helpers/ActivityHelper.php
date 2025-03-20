<?php

namespace App\Helpers;

use App\Models\Aktivitas;

class ActivityHelper
{
    public static function record($deskripsi)
    {
        Aktivitas::create([
            'deskripsi' => $deskripsi,
            'created_at' => now(),
        ]);
    }
}
