<ul class="nav nav-tabs">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
        <li class="nav-item">
            <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" data-toggle="tab" href="#blog-{{ $locale }}">{{ $property['name'] }}</a>
        </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
        <div id="blog-{{ $locale }}" class="tab-pane fade {{ $loop->iteration == 1 ? 'show active' : '' }}">
            <div class="form-group">
                <label>Title</label>
                <input name="multilang[{{ $locale }}][title]" type="text" class="form-control" value="{{ old('multilang.' . $locale . '.title') ?? ($blog->id && $blog->translate($locale) ? $blog->translate($locale)->title : '')   }}">
                @error('multilang.' . $locale . '.title')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="multilang[{{ $locale }}][content]" class="ckeditor-form form-control">{{ old('multilang.' . $locale . '.content') ?? ($blog->id && $blog->translate($locale) ? $blog->translate($locale)->content : '')   }}</textarea>
                @error('multilang.' . $locale . '.content')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Catageory</label>
            <select name="blog_category_id" id="" class="form-control select2">
                <option value="">Nothing selected</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : ($blog->blog_category_id == $category->id ? 'selected' : '') }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('blog_category_id')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Tag</label>
            <select name="tags[]" id="" class="form-control select2" multiple="">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags') ?? []) ? 'selected' : ($blog->tags->contains('id', $tag->id) ? 'selected' : '') }}>{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('tags')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>