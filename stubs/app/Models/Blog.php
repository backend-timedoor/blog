<?php

namespace App\Models;

use App\Http\Filter\BlogFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class Blog extends Model
{
    use HasFactory, Translatable, FilterTrait;

    protected $filterClass = BlogFilter::class;

    public $translatedAttributes = [
    	'title', 'content'
    ];

    protected $fillable = [
        'blog_category_id'
    ];

    protected $with = [
        'category', 'tags', 'translations'
    ];

    public function image()
    {
        return $this->hasOne(BlogImage::class)
            ->orderBy('sort_order');
    }

    public function images()
    {
        return $this->hasMany(BlogImage::class)
            ->orderBy('sort_order');
    }

    public function featured()
    {
        return $this->hasOne(BlogFeatured::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'pivot_blogs_tags', 'blog_id', 'blog_tag_id');
    }

    public function blogTags() // for seeding database
    {
        return $this->belongsToMany(BlogTag::class, 'pivot_blogs_tags', 'blog_id', 'blog_tag_id');
    }

    public function getThumbnailAttribute()
    {
        return optional($this->image)->image;
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
}
