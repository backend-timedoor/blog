@extends('admin-blog.layout.master')

@section('title', 'Blog Create')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin-blog.blog.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Create Blog</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin-blog.blog.index') }}">Blog</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Input Blog</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin-blog.blog.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            
                            @include('admin-blog.blog.shared')
                            <div class="form-group">
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('admin-blog.blog.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection