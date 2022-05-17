<?php

namespace App\Models;

use App\Http\Filter\CategoryFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Timedoor\Filter\FilterTrait;

class BlogCategory extends Model
{
    use HasFactory, Translatable, FilterTrait;

    const IMAGE_FOLDER = 'blog-category';

    protected $filterClass = CategoryFilter::class;

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
        return $this->hasMany(Blog::class);
    }
}
