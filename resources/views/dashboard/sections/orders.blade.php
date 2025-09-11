@extends('Layouts.dash')

@section('title', 'الطلبات')

@section('content')
    <div class="container-fluid">

        <div class="mb-4 mt-5">
            <h2 class="fw-bold">الطلبات</h2>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <label>بحث:</label>
                <input type="text" id="search" class="form-control form-control-sm" placeholder="ابحث بالاسم أو الإيميل">
            </div>
            <div class="col-md-4 mb-2">
                <label>فلتر حسب الحالة:</label>
                <select id="statusFilter" class="form-select form-select-sm">
                    <option value="">كل الحالات</option>
                    <option value="معلق">معلق</option>
                    <option value="مكتمل">مكتمل</option>
                    <option value="ملغى">ملغى</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label>فلتر حسب الفترة:</label>
                <select id="timeFilter" class="form-select form-select-sm">
                    <option value="">كل الوقت</option>
                    <option value="today">اليوم</option>
                    <option value="week">هذا الأسبوع</option>
                    <option value="month">هذا الشهر</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="ordersTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">الاسم</th>
                        <th class="text-center">الإيميل</th>
                        <th class="text-center">الهاتف</th>
                        <th class="status-col text-center">الحالة</th>
                        <th class="date-col text-center">تاريخ الطلب</th>
                        <th class="text-center">الإجمالي</th>
                        <th class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $statusColors = [
                                'معلق' => 'bg-warning text-dark',
                                'مكتمل' => 'bg-success text-dark',
                                'ملغى' => 'bg-danger text-dark',
                            ];
                            $currentColor = $statusColors[$order->status ?? 'معلق'] ?? '';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->name ?? ($order->user->name ?? 'غير معروف') }}</td>
                            <td>{{ $order->email ?? ($order->user->email ?? 'غير معروف') }}</td>
                            <td>{{ $order->phone ?? ($order->user->phone ?? 'غير معروف') }}</td>
                            <td class="status-cell {{ $currentColor }}">
                                <select class="form-select form-select-sm order-status" data-id="{{ $order->id }}"
                                    data-url="{{ route('dashboard.orders.updateStatus', $order->id) }}">
                                    @foreach (['معلق', 'مكتمل', 'ملغى'] as $status)
                                        <option value="{{ $status }}"
                                            {{ ($order->status ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="date-cell" data-date="{{ $order->created_at->format('Y-m-d') }}">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>{{ number_format($order->total, 2) }} $</td>
                            <td>
                                <a href="{{ route('dashboard.index', ['section' => 'orderDetails', 'id' => $order->id]) }}"
                                    class="btn btn-sm btn-info">عرض التفاصيل</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .status-cell {
            color: black !important;
            text-align: center;
        }

        .status-cell select {
            font-weight: bold;
            color: black !important;
            padding-right: 20px;
            min-width: 100px;
            background-position: left 6px center !important;
        }

        .bg-warning {
            background-color: #e4bc3a !important;
        }

        .bg-success {
            background-color: #4cff76 !important;
        }

        .bg-danger {
            background-color: #ff2537 !important;
        }

        .date-cell {
            font-size: 0.9rem;
            white-space: nowrap;
        }

        @media (max-width: 768px) {

            .status-col,
            .status-cell {
                min-width: 200px;
            }

            .date-col,
            .date-cell {
                min-width: 160px;
                font-size: 0.75rem;
            }
        }

        @media print {
            .status-cell select {
                display: none !important;
            }

            .status-cell::after {
                content: attr(data-status);
                font-weight: bold;
                color: black;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        $(function() {
            // ضبط data-status عند التحميل
            $('#ordersTable tbody tr').each(function() {
                var cell = $(this).find('.status-cell');
                var status = cell.find('select').val();
                cell.attr('data-status', status);
            });

            // إعداد DataTable
            var table = $('#ordersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'تصدير Excel',
                        exportOptions: {
                            columns: ':visible',
                            rows: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'تصدير PDF',
                        exportOptions: {
                            columns: ':visible',
                            rows: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'طباعة',
                        exportOptions: {
                            columns: ':not(:last)',
                            rows: ':visible',
                            format: {
                                body: function(data, node) {
                                    return $(node).hasClass('status-cell') ? $(node).attr(
                                        'data-status') : data;
                                }
                            }
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/Arabic.json",
                    paginate: {
                        previous: "السابق",
                        next: "التالي"
                    },
                    search: "بحث:",
                    lengthMenu: "أظهر _MENU_ صفوف",
                    info: "إظهار _START_ إلى _END_ من أصل _TOTAL_ صف",
                    infoEmpty: "لا توجد بيانات متاحة",
                    infoFiltered: "(مصفى من أصل _MAX_ صف)",
                    zeroRecords: "لم يتم العثور على سجلات مطابقة"
                },
                responsive: true
            });

            // عند تغيير الحالة
            $(document).on('change', '.order-status', function() {
                var select = $(this);
                var status = select.val();
                var cell = select.closest('td');
                var url = select.data('url');

                var colors = {
                    'معلق': 'bg-warning text-dark',
                    'مكتمل': 'bg-success text-dark',
                    'ملغى': 'bg-danger text-dark'
                };
                cell.removeClass('bg-warning bg-success bg-danger text-dark text-white').addClass(colors[
                    status]);
                cell.attr('data-status', status);

                $.ajax({
                    url: url,
                    method: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(res) {
                        console.log(res.message);
                        if (res.chartLabels && res.chartData) {
                            salesChart.data.labels = res.chartLabels;
                            salesChart.data.datasets[0].data = res.chartData;
                            salesChart.update();
                        }
                    },
                    error: function(err) {
                        alert('حدث خطأ أثناء تحديث حالة الطلب');
                        console.log(err);
                    }
                });
            });

            // الفلترة العامة
            function filterAllTables() {
                var search = $('#search').val()?.toLowerCase() || '';
                var statusFilter = $('#statusFilter').val() || '';
                var dateFilter = $('#timeFilter').val() || '';
                var now = new Date();
                var startOfWeek = new Date(now);
                startOfWeek.setDate(now.getDate() - now.getDay());
                startOfWeek.setHours(0, 0, 0, 0);
                var startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
                startOfMonth.setHours(0, 0, 0, 0);

                $('#ordersTable tbody tr').each(function() {
                    var row = $(this);
                    var name = row.find('td:eq(1)').text().toLowerCase();
                    var email = row.find('td:eq(2)').text().toLowerCase();
                    var status = row.find('td:eq(4)').data('status');
                    var dateStr = row.find('td:eq(5)').data('date');
                    var rowDate = dateStr ? new Date(dateStr + 'T00:00:00') : null;

                    var matchSearch = !search || name.includes(search) || email.includes(search);
                    var matchStatus = !statusFilter || status === statusFilter;
                    var matchTime = true;
                    if (rowDate) {
                        if (dateFilter === 'today') matchTime = rowDate.toDateString() === now
                            .toDateString();
                        else if (dateFilter === 'week') matchTime = rowDate >= startOfWeek;
                        else if (dateFilter === 'month') matchTime = rowDate >= startOfMonth;
                    }
                    row.toggle(matchSearch && matchStatus && matchTime);
                });
            }
            $('#search,#statusFilter,#timeFilter').on('keyup change', filterAllTables);
            filterAllTables();
        });
    </script>
@endpush
