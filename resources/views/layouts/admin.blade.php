<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIU Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tabulator -->
    <link href="https://unpkg.com/tabulator-tables@6.3.0/dist/css/tabulator_semanticui.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@6.3.0/dist/js/tabulator.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen">

    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="ml-0 lg:ml-64 p-4 md:p-8 pb-24 lg:pb-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
