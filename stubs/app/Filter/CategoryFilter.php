<?php

namespace App\Http\Filter;

use Timedoor\Filter\Filter;

class CategoryFilter extends Filter
{
    public function keyword($value) // write your method name based on param name
    {
        return $this->query->whereHas('translation', function($translate) use ($value) {
            return $translate->where("name", "LIKE", "%$value%");
        });
    }
}