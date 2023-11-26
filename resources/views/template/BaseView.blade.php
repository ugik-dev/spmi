<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="SungailiatDev | Bangka Belitung">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' | ' : '' }} SPMI Smart System </title>

    <!-- Favicons -->
    @include('partials.favicons')
    <!-- Partial for favicon links -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">


    <!-- App CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('template.sidebar.auth')
        <!-- Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('template.navbar')
                <!-- Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            @include('template.footer')
            <!-- Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    @include('template.scroll-to-top')

    <!-- Logout Modal-->
    @include('template.logout-modal')

    {{-- <script src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script> --}}

    <!-- App JS -->
    <script src="{{ mix('js/app.js') }}"></script>
    {{-- <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
    @stack('scripts')

    <!-- Custom JS Scripts -->
    <script>
        // $(document).ready(function() {

        function swalLoading() {
            Swal.fire({
                title: 'Loading!',
                allowOutsideClick: false,
                customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light d-none'
                },
                buttonsStyling: false
            });
            Swal.showLoading();
        }

        function swalBerhasil(label = 'Berhasil !!', btn = true) {
            btnclass = btn ? '' : 'd-none';
            Swal.fire({
                title: label,
                icon: 'success',
                showClass: {
                    popup: 'animate__animated animate__flipInX'
                },
                allowOutsideClick: false,
                customClass: {
                    confirmButton: `btn btn-primary waves-effect waves-light ${btnclass}`
                },
                buttonsStyling: false
            });
        }

        function swalError(message = '', label = 'Gagal !!', btn = true) {
            Swal.fire({
                title: label,
                icon: 'error',
                text: message,
                showClass: {
                    popup: 'animate__animated animate__flipInX'
                },
                allowOutsideClick: true,
                customClass: {
                    confirmButton: `btn btn-primary waves-effect waves-light`
                },
                buttonsStyling: false
            });
        }

        function SwalOpt(title = 'Apakah anda yakin ?', text = 'Data akan disimpan!', icon = 'warning') {
            return {
                title: title,
                icon: icon,
                text: text,
                allowOutsideClick: false,

                showCancelButton: true,
                confirmButtonText: 'Ya !!',
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-outline-danger waves-effect'
                }
            };
        }
        // });
    </script>
    <script>
        // To see/hide password input
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>

</html>