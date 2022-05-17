@extends('admin-blog.layout.master')

@section('title', 'Blog Featured')

@section('css')
<link rel="stylesheet" href="{{ asset('blog/css/jquery.flexdatalist.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('blog/js/jquery.flexdatalist.min.js') }}"></script>
<script src="{{ asset('blog/js/jquery-ui.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
            $(this).height($(this).height());
        });

        return ui;
    };

    $("#blog-sortable").sortable({
        items: ".blog-sortable",
        cancel: ".not-sortable",
        appendTo: "parent",
        opacity: 0,
        containment: "document",
        placeholder: "ui-state-highlight blog-sortable-my-placeholder",
        cursor: "move",
        delay: 0,
        helper: fixHelper,
        stop: function(event, ui) {
            var data = $(this).sortable('serialize');
            update_order($(this), data);
        }
    }).disableSelection();

    function update_order(selector, data) {
        var url = "{{ route('admin-blog.blog-featured.sort') }}";

        console.log(data);

        $.post(url, data, function() {}, 'json').done(function(result) {
            console.log(result);
        }).fail(function(e) {
            // $.notifyClose();
            console.log(data);
            selector.sortable("cancel");
            // $.notify({message:"System failure!, Please contact administrator!", type:"danger"}, {placement: {from: "top", align: "right"}, newest_on_top: true});

            console.log(e);
        });
    }

    $('.flexdatalist').flexdatalist({
        minLength: 1,
        selectionRequired: true,
        url: "{{ route('admin-blog.blog-featured.filter') }}",
        resultsProperty: 'data',
        valueProperty: 'id',
        searchIn: 'title',
        searchContain: true,
        visibleProperties: ['title']
    });

    $('.flexdatalist').on('select:flexdatalist', function(event, set, options) {
        $('#btn-save').removeAttr('disabled');
    });
</script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Blog Featured</h1>
        <div class="section-header-button">
            <button class="btn btn-primary" data-target="#modal-add" data-toggle="modal">Add Blog</button>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">Blog Featured</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Blog Featured List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th width="175px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="blog-sortable">
                                    @foreach ($blogs as $blog)
                                    <tr class="blog-sortable" style="cursor: grab;" id="blog-{{ $blog->id }}">
                                        <td>
                                            <span class="d-block py-2" style="max-width: 200px;">
                                                <img class="img-fluid w-100" src="{{ $blog->thumbnail ? asset('upload/images/blog-image/' . $blog->thumbnail) : '' }}" alt="">
                                            </span>
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-delete not-sortable" type="button" data-url="{{ route('admin-blog.blog-featured.delete', $blog->id) }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin-blog.blog-featured.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Blog Title</label>
                        <input type="text" class="form-control flexdatalist" value="" name="blog">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-save" disabled>Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection