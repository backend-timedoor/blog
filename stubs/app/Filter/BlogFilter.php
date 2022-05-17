<?php

namespace App\Http\Filter;

use Timedoor\Filter\Filter;

class BlogFilter extends Filter
{
    public function keyword($value)
    {
        return $this->query->whereHas('translation', function($translate) use ($value) {
            return $translate->where("title", "LIKE", "%$value%")
                ->orWhere('content', 'LIKE', "%$value%");
        });
    }

    public function category($value)
    {
        return $this->query->where('blog_category_id', $value);
    }

    public function tags($value)
    {
        return $this->query->whereHas('tags', function($tag) use($value) {
            return $tag->whereIn('id', $value);
        });
    }

    public function published($value)
    {
        $order = $value == 'oldest' ? 'ASC' : 'DESC';

        return $this->query->orderBy('published_at', $order);
    }
}