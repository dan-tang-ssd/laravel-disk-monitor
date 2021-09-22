<?php

namespace Spatie\LaravelDiskMonitor\Models;

use Illuminate\Database\Eloquent\Model;

class DiskMonitorEntry extends Model
{

    public $guarded = [];

    // to cast file_count from a string to an integer
    public $casts = [
        'file_count' => 'integer',
    ];
    
    public static function last(): ?self 
    {
        return static::orderByDesc('id')->first();
    }

}