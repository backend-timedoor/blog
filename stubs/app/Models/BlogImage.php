<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class BlogImage extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    const IMAGE_FOLDER = 'blog-image';

    protected $fillable = [
        'image'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('blog_id', $this->blog_id);
    }
}
