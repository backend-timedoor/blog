<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultilanguageSettingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'script', 'native', 'regional'
    ];

    public function setting()
    {
        return $this->belongsTo(MultilanguageSetting::class);
    }
}
