<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('image/icon.png') }}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-shorten@0.3.2/dist/css/shorten.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('stisla/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
    <style>
        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="main-wrapper main-wrapper-1" id="app">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('admin-blog.layout.header')
        </nav>
        <div class="main-sidebar sidebar-style-2">
            @include('admin-blog.layout.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Page Content -->
            @yield('content')
        </div>
        <footer class="main-footer">
        </footer>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="form-delete">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Do you want to continue?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('stisla/js/stisla.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-shorten@0.3.2/dist/jquery-shorten.min.js"></script>
    <script src="{{ asset('stisla/js/select2.js') }}"></script>
    <script src="{{ asset('stisla/js/scripts.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="{{ asset('blog/js/ckeditor.jquery.adapter.js') }}"></script>
    <script>
        $('.ckeditor-form').ckeditor({
            filebrowserImageBrowseUrl: '/admin-blog/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin-blog/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/admin-blog/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/admin-blog/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
        });
    </script>
    <script>
        $(function() {
            $('.loading').hide();

            $('form').submit(function(e) {
                $('.loading').show();
            })
        })

        $('.btn-delete').click(function() {
            let url = $(this).data('url');

            $('#form-delete').attr('action', url);
            $('#modal-delete').modal();
        });

        var token = $('meta[name="csrf-token"]').attr('content')
    </script>
    @yield('js')
</body>

</html>