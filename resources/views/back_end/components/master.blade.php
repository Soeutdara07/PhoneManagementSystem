<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nexus Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('back_end/assets/css/style.css') }}">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Toastify messages -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->

    @include('back_end.components.sidebar')

    <!-- End Sidebar -->



    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        @include('back_end.components.navbar')
        <!-- End Top Navbar -->

        <!-- Content Area -->
        <div class="content-area">
            <!-- Stats Cards Row -->
            @yield('contents')
        </div>
    </div>
    </div>



    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap Bundle (with Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Dashboard JS -->
    <script src="{{ asset('back_end/assets/js/dashboard.js') }}"></script>

    <!-- Toastify messages -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- CSRF Token for Ajax -->
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Initialize Select2
        $(document).ready(function () {
            $('.form-select').select2({
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
        });

        const Message = (message, status = 200) => {
            console.log('Message called:', message, status); // debug

            let bgColor;
            if (status === 200) bgColor = "linear-gradient(to right, #00b09b, #96c93d)";
            else if (status === 500) bgColor = "linear-gradient(to right, #e52d27, #b31217)";
            else bgColor = "linear-gradient(to right, #00b09b, #96c93d)";

            Toastify({
                text: message || 'No message',
                duration: 2000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: bgColor
                },
            }).showToast();
        };
    </script>

    @yield('scripts')
</body>


</html>
