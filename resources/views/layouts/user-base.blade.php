<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
        <title>{{ env('APP_NAME') }} - @yield('title')</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('icons/kami_sewain_30_x_30.png') }}" />
        <!-- Site favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/kami_sewain_30_x_30.png') }}">
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        {{-- FONT AWESOME --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/core.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/icon-font.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

        {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    </head>
    <body>
        @section('body')
            @include('layouts.partials.header')
            <main class="main">
                @yield('main')
            </main>
        @endsection
        @yield('body')
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.en.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/app.js') }}"> </script>
        {{-- <script src="{{ asset('js/custom.js') }}"> </script> --}}
        <script src="{{ asset('vendors/datatables/scripts/core.js') }}"></script>
        <script src="{{ asset('vendors/datatables/scripts/script.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/scripts/process.js') }}"></script>
        <script src="{{ asset('vendors/datatables/scripts/layout-settings.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('vendors/datatables/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('vendors/datatables/scripts/datatable-setting.js') }}"></script>


    </body>
</html>