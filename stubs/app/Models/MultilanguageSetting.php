<?php

namespace App\Models;

use App\Http\Filter\MultiLanguageFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class MultilanguageSetting extends Model
{
    use HasFactory, FilterTrait;

    protected $filterClass = MultiLanguageFilter::class;

    protected $fillable = [
        'locale', 'is_enable'
    ];

    protected $with = [
        'detail'
    ];

    protected $casts = [
        'is_enable' => 'boolean'
    ];

    public function detail()
    {
        return $this->hasOne(MultilanguageSettingDetail::class);
    }

    public function scopeEnable($query)
    {
        return $query->whereIsEnable(true);
    }
}
