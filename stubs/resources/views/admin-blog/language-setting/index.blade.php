@extends('admin-blog.layout.master')

@section('title', 'Tag')

@section('css')
<link rel="stylesheet" href="{{ asset('blog/css/jquery.flexdatalist.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('blog/js/jquery.flexdatalist.min.js') }}"></script>
@if ($errors->any()) 
<script>
    $('#modal-add').modal();
</script>
@endif

<script>
    $('.flexdatalist').flexdatalist({
        minLength: 1,
        selectionRequired: true,
        url: '{{ route("admin-blog.language.setting.search-language") }}',
        resultsProperty: 'data',
        valueProperty: 'id',
        searchIn: 'name',
        searchContain: true,
        visibleProperties: ['name']
    });

    $('.flexdatalist').on('select:flexdatalist', function(event, set, options) {
        $('#btn-save').removeAttr('disabled');
    });
</script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Language</h1>
        <div class="section-header-button">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add">Add Language</button>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">Language</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Language List</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <form action="{{ route('admin-blog.language.setting.index') }}">
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
                                        <th>Name</th>
                                        <th width="175px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $language)
                                    <tr>
                                        <td>{{ $language->detail->name }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-delete" type="button" data-url="{{ route('admin-blog.language.setting.delete', $language->id) }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $languages->appends(Request::except('page'))->links() }}
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
                <h5 class="modal-title">Add New Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin-blog.language.setting.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Language</label>
                        <input type="text" name="language_id" class="form-control flexdatalist" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="form_type" value="store">
                    <button type="submit" class="btn btn-primary" id="btn-save" disabled>Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection