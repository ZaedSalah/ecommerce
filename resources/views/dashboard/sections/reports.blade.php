@extends('Layouts.dash')

@section('title', 'تقارير المبيعات')

@section('content')
    <div class="container-fluid py-4">

        <!-- ===== عنوان الصفحة ===== -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <h3 class="fw-bold">📊 تقارير المبيعات</h3>
            </div>
        </div>

        <!-- ===== Summary Cards ===== -->
        <div class="row mb-5 g-4">
            @php
                $cards = [
                    [
                        'icon' => 'bi-cart-check-fill',
                        'gradient' => 'linear-gradient(135deg, #42a5f5, #478ed1)',
                        'title' => 'إجمالي الطلبات',
                        'value' => $ordersCount,
                    ],
                    [
                        'icon' => 'bi-people-fill',
                        'gradient' => 'linear-gradient(135deg, #66bb6a, #43a047)',
                        'title' => 'إجمالي المستخدمين',
                        'value' => $usersCount,
                    ],
                    [
                        'icon' => 'bi-box-seam',
                        'gradient' => 'linear-gradient(135deg, #ffeb3b, #fbc02d)',
                        'title' => 'إجمالي المنتجات',
                        'value' => $productsCount,
                    ],
                    [
                        'icon' => 'bi-currency-dollar',
                        'gradient' => 'linear-gradient(135deg, #ab47bc, #8e24aa)',
                        'title' => 'إجمالي المبيعات ($)',
                        'value' => $salesTotal,
                    ],
                ];
            @endphp

            @foreach ($cards as $c)
                <div class="col-md-3 col-6">
                    <div class="card shadow-lg text-center hover-card"
                        style="border-radius:12px; background:{{ $c['gradient'] }}; color:#fff;">
                        <div class="card-body py-4">
                            <i class="bi {{ $c['icon'] }} fs-2 mb-4"></i>
                            <h6>{{ $c['title'] }}</h6>
                            <h4 class="fw-bold counter" data-target="{{ $c['value'] }}">0</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ===== Tables ===== -->
        <div class="card mb-5 shadow-lg hover-card" style="border-radius:12px;">
            <div class="card-header" style="background-color:#29b6f6; color:#fff;">
                <h5 class="mb-0"><i class="bi bi-bar-chart-line-fill me-2"></i>أعلى 5 منتجات مبيعًا</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background-color:#b3e5fc;">
                            <tr>
                                <th>المنتج</th>
                                <th>إجمالي الكمية</th>
                                <th>إجمالي الإيرادات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topProducts as $prod)
                                <tr>
                                    <td>{{ $prod->name }}</td>
                                    <td>{{ $prod->total_quantity }}</td>
                                    <td>{{ $prod->total_revenue }} $</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-5 shadow-lg hover-card" style="border-radius:12px;">
            <div class="card-header" style="background-color:#66bb6a; color:#fff;">
                <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>أعلى 5 مستخدمين شراءً</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background-color:#c8e6c9;">
                            <tr>
                                <th>المستخدم</th>
                                <th>عدد الطلبات</th>
                                <th>إجمالي الشراء ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->total_orders }}</td>
                                    <td>{{ $user->total_spent }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== Charts ===== -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-lg hover-card" style="border-radius:12px;">
                    <div class="card-header" style="background-color:#ffb74d; color:#000;">
                        <h5 class="mb-0"><i class="bi bi-calendar-fill me-2"></i>مبيعات حسب الفترة</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-lg hover-card" style="border-radius:12px;">
                    <div class="card-header" style="background-color:#4dd0e1; color:#000;">
                        <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>مبيعات حسب المنتج</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card shadow-lg hover-card" style="border-radius:12px;">
                    <div class="card-header" style="background-color:#ba68c8; color:#fff;">
                        <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>مبيعات حسب المستخدم</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .hover-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
            cursor: pointer;
        }

        .counter {
            font-size: 1.8rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ===== Counter Animation عند ظهور الكارت =====
        const counters = document.querySelectorAll('.counter');
        const options = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    let target = parseInt(el.getAttribute('data-target'));
                    let count = 0;
                    const step = target / 100; // 100 steps
                    const interval = setInterval(() => {
                        count += step;
                        if (count >= target) {
                            count = target;
                            clearInterval(interval);
                        }
                        el.textContent = Math.floor(count);
                    }, 15);
                    observer.unobserve(el);
                }
            });
        }, options);

        counters.forEach(counter => observer.observe(counter));

        // ===== Charts =====
        const salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: @json($sales->pluck('period')),
                datasets: [{
                    label: 'إجمالي المبيعات',
                    data: @json($sales->pluck('total_sales')),
                    backgroundColor: 'rgba(33,150,243,0.7)',
                    borderColor: 'rgba(33,150,243,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const productChart = new Chart(document.getElementById('productChart'), {
            type: 'bar',
            data: {
                labels: @json($topProducts->pluck('name')),
                datasets: [{
                    label: 'إجمالي المبيعات',
                    data: @json($topProducts->pluck('total_revenue')),
                    backgroundColor: 'rgba(0,188,212,0.7)',
                    borderColor: 'rgba(0,188,212,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const userChart = new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: @json($topUsers->pluck('name')),
                datasets: [{
                    label: 'إجمالي الشراء',
                    data: @json($topUsers->pluck('total_spent')),
                    backgroundColor: 'rgba(156,39,176,0.7)',
                    borderColor: 'rgba(156,39,176,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
