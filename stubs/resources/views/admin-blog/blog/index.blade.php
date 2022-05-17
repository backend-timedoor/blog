@extends('admin-blog.layout.master')

@section('title', 'Blog')

@section('css')

@endsection

@section('js')

@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Blogs</h1>
        <div class="section-header-button">
            <a class="btn btn-primary" href="{{ route('admin-blog.blog.create') }}">Add Blogs</a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">Blogs</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Blogs List</h4>
                    </div>
                    <div class="card-body">
                        <div class="float-right">
                            <form action="{{ route('admin-blog.blog.index') }}">
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
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th width="200px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->content }}</td>
                                            <td>
                                                <a href="{{ route('admin-blog.blog.edit', $blog->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('admin-blog.blog.image.index', $blog->id) }}" class="btn btn-primary"><i class="far fa-image"></i></a>
                                                <button class="btn btn-danger btn-delete" type="button" data-url="{{ route('admin-blog.blog.delete', $blog->id) }}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $blogs->appends(Request::except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
