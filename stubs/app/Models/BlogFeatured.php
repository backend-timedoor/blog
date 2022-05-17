<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class BlogFeatured extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $with = [
        'blog'
    ];

    protected $fillable = [
        'blog_id'
    ];

    public $sortable = [
        'order_column_name'  => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
