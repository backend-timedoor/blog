<?php

namespace App\Models;

use App\Http\Filter\TagFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class BlogTag extends Model
{
    use HasFactory, Translatable, FilterTrait;

    const IMAGE_FOLDER = 'blog-tag';

    protected $filterClass = TagFilter::class;
    
    protected $fillable = [
        'image'
    ];

    public $translatedAttributes = [
    	'name'
    ];

    protected $with = [
        'translations'
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'pivot_blogs_tags', 'blog_tag_id', 'blog_id');
    }
}
