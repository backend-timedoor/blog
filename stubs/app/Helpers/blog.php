<?php

use App\Models\MultilanguageSetting;
use Illuminate\Support\Facades\Cache;

function getMultilanguageSetting()
{
    $settings = Cache::get('settings');

    if(is_null($settings))
    {
        $settings = Cache::remember('settings', 24*60, function() {
            return MultilanguageSetting::enable()->get();
        });
    }

    return $settings;
}

function forgetCache($key = 'settings') 
{
    Cache::forget($key);
}

function getTranslation($model, $locale = null)
{
    return $model->translate($locale) ?? $model->translate();
}