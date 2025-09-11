<!-- resources/views/dashboard/stats.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إحصائيات لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="container my-4">
        <h2 class="mb-4">إحصائيات المنتجات والمستخدمين</h2>

        <!-- KPIs -->
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h5>إجمالي المنتجات</h5>
                        <h3>{{ $totalProducts }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h5>المنتجات المتاحة</h5>
                        <h3>{{ $availableProducts }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h5>المنتجات منتهية الكمية</h5>
                        <h3>{{ $outOfStockProducts }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h5>إجمالي المستخدمين</h5>
                        <h3>{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart: المنتجات حسب الفئة -->
        <div class="card p-3">
            <h5 class="mb-3">المنتجات حسب الفئة</h5>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($productsByCategory as $item)
                        '{{ $item->Category?->name ?? 'بدون فئة' }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'عدد المنتجات',
                    data: [
                        @foreach ($productsByCategory as $item)
                            {{ $item->count }},
                        @endforeach
                    ],
                    backgroundColor: '#198754'
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
</body>

</html>
