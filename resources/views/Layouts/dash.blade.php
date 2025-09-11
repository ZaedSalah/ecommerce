<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - @yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">


    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Sidebar */
        #sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #343a40;
            color: #fff;
            padding-top: 60px;
            /* حتى لا يدخل على الهيدر */
            transition: transform 0.3s ease;
            z-index: 9999;
        }

        #sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        #sidebar a.active,
        #sidebar a:hover {
            background-color: #495057;
        }

        /* Content */
        .content {
            margin-right: 220px;
            padding: 20px;
            transition: margin 0.3s ease;
        }

        /* Fixed header */
        .dashboard-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            background-color: #343a40;
            color: #fff;
            z-index: 10003;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header h4 {
            margin: 0;
            font-size: 1.25rem;
        }

        /* Mobile / Tablet */
        @media (max-width: 1199.98px) {

            /* أقل من XL */
            #sidebar {
                transform: translateX(100%);
                width: 220px;
                height: 100%;
                z-index: 10001;
            }

            #sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin: 0;
                padding-top: 70px;
                /* بسبب الهيدر الثابت */
            }
        }

        /* Overlay */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 10000;
        }

        #overlay.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Header ثابت مع زر الهامبرغر للموبايل والتابلت -->
    <div class="dashboard-header">
        <h4 class="m-0">لوحة التحكم</h4>
        <div class="mobile-navbar d-xl-none">
            <button id="mobileSidebarToggle" class="btn btn-outline-light btn-sm">
                <i class="bi bi-list" id="hamburgerIcon"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <a href="{{ route('dashboard.index', ['section' => 'home']) }}"
            class="{{ request('section') == 'home' ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> الرئيسية
        </a>
        <a href="{{ route('dashboard.index', ['section' => 'orders']) }}"
            class="{{ request('section') == 'orders' ? 'active' : '' }}">
            <i class="bi bi-card-checklist"></i> الطلبات
        </a>
        <a href="{{ route('dashboard.index', ['section' => 'categories']) }}"
            class="{{ request('section') == 'categories' ? 'active' : '' }}">
            <i class="bi bi-tags-fill"></i> الفئات
        </a>
        <a href="{{ route('dashboard.index', ['section' => 'products']) }}"
            class="{{ request('section') == 'products' ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> المنتجات
        </a>
        @if (Auth::user() && Auth::user()->role == 'superadmin')
            <a href="{{ route('dashboard.index', ['section' => 'users']) }}"
                class="{{ request('section') == 'users' ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> المستخدمين
            </a>
        @endif
        <a href="{{ route('dashboard.index', ['section' => 'reports']) }}"
            class="{{ request('section') == 'reports' ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> التقارير
        </a>
    </div>

    <!-- Overlay -->
    <div id="overlay"></div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(function() {
            const sidebar = $('#sidebar');
            const overlay = $('#overlay');
            const toggleBtn = $('#mobileSidebarToggle');
            const hamburgerIcon = $('#hamburgerIcon');

            toggleBtn.on('click', function() {
                sidebar.toggleClass('show');
                overlay.toggleClass('show');
                hamburgerIcon.toggleClass('bi-list').toggleClass('bi-x');
            });

            overlay.on('click', function() {
                sidebar.removeClass('show');
                overlay.removeClass('show');
                hamburgerIcon.removeClass('bi-x').addClass('bi-list');
            });
        });
    </script>
    @stack('styles')

    @stack('scripts')
</body>

</html>
