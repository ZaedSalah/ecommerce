@extends('Layouts.dash')
@section('title', 'الرئيسية')

@section('content')
    <div class="container-fluid py-4">

        {{-- العنوان --}}
        <div class="mb-4 mt-5">
            <h2 class="fw-bold">الرئيسية</h2>
        </div>

        {{-- الكروت --}}
        <div class="row g-3 mb-4">
            @php
                $cards = [
                    ['title' => 'عدد المستخدمين', 'value' => $usersCount, 'color' => 'primary', 'bg' => '#e3f2fd'],
                    ['title' => 'عدد المنتجات', 'value' => $productsCount, 'color' => 'success', 'bg' => '#e8f5e9'],
                    ['title' => 'إجمالي المبيعات', 'value' => $salesTotal, 'color' => 'danger', 'bg' => '#ffebee'],
                    ['title' => 'إجمالي الأرباح', 'value' => $totalProfit, 'color' => 'warning', 'bg' => '#fff8e1'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-3 fade-element">
                    <div class="card shadow-lg border-0 text-center p-5 card-hover" style="background: {{ $card['bg'] }}">
                        <h6 class="text-muted">{{ $card['title'] }}</h6>
                        <h3 class="counter text-{{ $card['color'] }}" data-target="{{ $card['value'] }}">0</h3>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- الفلترة --}}
        <form method="GET" class="card shadow-lg border-0 mb-4 fade-element">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">المستخدم</label>
                        <select name="user" class="form-select" onchange="this.form.submit()">
                            <option value="">كل المستخدمين</option>
                            @foreach ($users as $userOption)
                                <option value="{{ $userOption->name }}"
                                    {{ request('user') == $userOption->name ? 'selected' : '' }}>{{ $userOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">المنتج</label>
                        <select name="product" class="form-select" onchange="this.form.submit()">
                            <option value="">كل المنتجات</option>
                            @foreach ($allProducts as $productOption)
                                <option value="{{ $productOption->name }}"
                                    {{ request('product') == $productOption->name ? 'selected' : '' }}>
                                    {{ $productOption->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="ابحث...">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">تطبيق الفلتر</button>
                    </div>
                </div>
            </div>
        </form>

        {{-- جدول المستخدمين --}}
        <div class="card shadow-lg border-0 mb-4 fade-element">
            <div class="card-header bg-gradient-primary text-dark">
                <h5 class="mb-0">جدول المستخدمين</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle mb-0 table-hover-scale" id="usersTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الايميل</th>
                            <th>عدد الطلبات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr
                                data-last-order-date="{{ optional($user->orders->first())->created_at?->format('Y-m-d') }}">
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->orders_count ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-2">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>

        {{-- جدول المنتجات --}}
        <div class="card shadow-lg border-0 mb-4 fade-element">
            <div class="card-header bg-gradient-success text-dark">
                <h5 class="mb-0">جدول المنتجات</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle mb-0 table-hover-scale" id="productsTable">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>اسم المنتج</th>
                            <th>السعر</th>
                            <th>الكمية المباعة</th>
                            <th>إجمالي الأرباح</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allProducts as $index => $product)
                            <tr
                                data-last-sale-date="{{ optional($product->orderdetails->first())->created_at?->format('Y-m-d') }}">
                                <td>{{ $allProducts->firstItem() + $index }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->sold_quantity ?? 0 }}</td>
                                <td>{{ number_format($product->total_profit ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-2">
                    {{ $allProducts->withQueryString()->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>

        {{-- الرسوم البيانية --}}
        <div class="card shadow-lg border-0 fade-element">
            <div class="card-header bg-gradient-info text-dark">
                <h5 class="mb-0">إحصائيات بيانية</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .fade-element {
            opacity: 0;
            transform: translateY(20px);
            transition: 0.6s;
        }

        .fade-element.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-hover:hover {
            transform: scale(1.05);
            transition: 0.3s;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }

        .table-hover-scale tbody tr:hover {
            transform: scale(1.02);
            transition: 0.2s;
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.addEventListener('load', () => {
            document.querySelectorAll('.fade-element').forEach((el, i) => setTimeout(() => el.classList.add('show'),
                i * 150));

            document.querySelectorAll('.counter').forEach(counter => {
                let target = +counter.getAttribute('data-target');
                let count = 0;
                let step = Math.ceil(target / 100);
                let interval = setInterval(() => {
                    count += step;
                    if (count >= target) {
                        count = target;
                        clearInterval(interval);
                    }
                    counter.textContent = count;
                }, 20);
            });
        });

        // Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'المبيعات',
                    data: @json($chartData),
                    borderColor: '#ff5722',
                    backgroundColor: @json($chartColors), // هنا استخدمنا الألوان حسب المبيعات
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ff5722'
                }]

            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // ضبط حجم الرسم حسب الشاشة
        function resizeChart() {
            const canvasParent = salesChart.canvas.parentNode;
            canvasParent.style.height = window.innerWidth <= 576 ? '300px' : '500px';
            salesChart.update();
        }
        window.addEventListener('resize', resizeChart);
        resizeChart();
    </script>
@endpush
