@extends('admin-blog.layout.master')

@section('title', 'Tag')

@section('css')

@endsection

@section('js')
@if ($errors->any() && old('form_type') == 'store')
<script>
    $('#modal-add').modal();
</script>
@elseif ($errors->any() && old('form_type') == 'edit')
<script>
    $('#modal-edit').modal();
</script>
@endif

<script>
    $('.btn-edit').click(function() {
        let url = $(this).data('url');
        let data = $(this).data('params');

        $.each(data.translations, function(index, tag) {
            $('#form-edit #input-name-' + tag.locale).val(tag.name ?? '');
        });

        $('#form-edit').attr('action', url);
        $('#form-edit input[name="url"]').val(url);

        $('#modal-edit').modal();
    });
</script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tags</h1>
        <div class="section-header-button">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add">Add Tags</button>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">Tags</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Tags List</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <form action="{{ route('admin-blog.tag.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request()->get('keyword') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="clearfix mb-3"></div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th width="175px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $tag)
                                    <tr>
                                        <td>
                                            <span class="d-inline-block py-2" style="max-width: 150px;">
                                                <img src="{{ $tag->image ? asset('upload/images/blog-tag/' . $tag->image) : 'https://via.placeholder.com/700x350' }}" alt="Tags Image" class="img-fluid w-100">
                                            </span>
                                        </td>
                                        <td>{{ $tag->name }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-edit" data-params="{{ $tag }}" data-url="{{ route('admin-blog.tag.update', $tag->id) }}"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-danger btn-delete" type="button" data-url="{{ route('admin-blog.tag.delete', $tag->id) }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $tags->appends(Request::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin-blog.tag.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        @if (old('form_type') == 'store')
                        @error('image')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                        @endif
                    </div>
                    <ul class="nav nav-tabs">
                        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" data-toggle="tab" href="#tag-{{ $locale }}">{{ $property['name'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
                        <div id="tag-{{ $locale }}" class="tab-pane fade {{ $loop->iteration == 1 ? 'show active' : '' }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="multilang[{{ $locale }}][name]" type="text" class="form-control" value="{{ old('form_type') == 'store' ? old('multilang.' . $locale . '.name') : '' }}">
                                @if (old('form_type') == 'store')
                                @error('multilang.' . $locale . '.name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="form_type" value="store">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ old('url') }}" method="post" enctype="multipart/form-data" id="form-edit">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        @if (old('form_type') == 'edit')
                        @error('image')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                        @endif
                    </div>
                    <ul class="nav nav-tabs">
                        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->iteration == 1 ? 'active' : '' }}" data-toggle="tab" href="#tag-edit-{{ $locale }}">{{ $property['name'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $property)
                        <div id="tag-edit-{{ $locale }}" class="tab-pane fade {{ $loop->iteration == 1 ? 'show active' : '' }}">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="multilang[{{ $locale }}][name]" id="input-name-{{ $locale }}" type="text" class="form-control" value="{{ old('form_type') == 'edit' ? old('multilang.' . $locale . '.name') : '' }}">
                                @if (old('form_type') == 'edit')
                                @error('multilang.' . $locale . '.name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="url" value="{{ old('url') }}">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection