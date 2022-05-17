<?php

namespace App\Http\Filter;

use Timedoor\Filter\Filter;

class MultiLanguageFilter extends Filter
{
    public function keyword($value) // write your method name based on param name
    {
        return $this->query->whereHas('detail', function($detail) use ($value) {
            return $detail->where('name', 'LIKE', "%$value%");
        });
    }
}