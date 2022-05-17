@extends('admin-blog.layout.master')

@section('title', 'Blog Image')

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
<script src="{{ asset('blog/js/jquery-ui.min.js') }}"></script>
<script>
    $('.btn-edit').click(function() {
        let url = $(this).data('url');

        $('#form-edit').attr('action', url);
        $('#form-edit input[name="url"]').val(url);

        $('#modal-edit').modal();
    });

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

    $("#image-sortable").sortable({
        items: ".image-sortable",
        cancel: ".not-sortable",
        appendTo: "parent",
        opacity: 0,
        containment: "document",
        placeholder: "ui-state-highlight image-sortable-my-placeholder",
        cursor: "move",
        delay: 0,
        helper: fixHelper,
        stop: function(event, ui) {
            var data = $(this).sortable('serialize');
            update_order($(this), data);
        }
    }).disableSelection();

    function update_order(selector, data) {
        var url = "{{ route('admin-blog.blog.image.sort', $blog->id) }}";

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
</script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Blog Image</h1>
        <div class="section-header-button">
            <button class="btn btn-primary" data-target="#modal-add" data-toggle="modal">Add Blog Image</button>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">Blog Image</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-custom">
                        <h4>Blog Image List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th width="175px">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="image-sortable">
                                    @foreach ($blog->images as $image)
                                    <tr class="image-sortable" style="cursor: grab;" id="image-{{ $image->id }}">
                                        <td>
                                            <span class="d-block py-2" style="max-width: 200px;">
                                                <img class="img-fluid w-100" src="{{ asset('upload/images/blog-image/' . $image->image) }}" alt="">
                                            </span>
                                        </td>
                                        <td>
                                            <button data-url="{{ route('admin-blog.blog.image.update', [$image->blog_id, $image->id]) }}" class="btn btn-primary btn-edit not-sortable"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-danger btn-delete not-sortable" type="button" data-url="{{ route('admin-blog.blog.image.delete', [$image->blog_id, $image->id]) }}"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin-blog.blog.image.store', $blog->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
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
                        </div>
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
                    <div class="row">
                        <div class="col-sm-12">
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
                        </div>
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