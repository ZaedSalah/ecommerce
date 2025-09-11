@extends('layouts.dash')

@section('title', 'الفئات')

@section('content')
    <div class="container-fluid">

        <!-- العنوان الرئيسي -->
        <div class="mb-4 mt-5">
            <h3 class="fw-bold">الفئات</h3>
        </div>
        <div class="row mb-4">
            <div class="col text-center">
                <a href="{{ route('categories.add') }}" class="btn btn-success btn-lg shadow-sm">
                    <i class="bi bi-plus-lg"></i> إضافة فئة جديدة
                </a>
            </div>
        </div>
        <!-- جدول الفئات -->
        <div class="table-responsive shadow-sm rounded">
            <table id="categoriesTable" class="table table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:50%" class="text-center">اسم الفئة</th>
                        <th style="width:20%"class="text-center">عدد المنتجات</th>
                        <th style="width:25%"class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td class="text-center">{{ $cat->name }}</td>
                            <td>
                                <span class="badge bg-primary px-3 py-2 shadow-sm">
                                    {{ $cat->products_count }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.index', ['section' => 'categoryProducts', 'id' => $cat->id]) }}"
                                    class="btn btn-info btn-sm shadow-sm">
                                    <i class="bi bi-eye"></i> عرض المنتجات
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
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
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: '📋 نسخ'
                    },
                    {
                        extend: 'csv',
                        text: '📑 CSV'
                    },
                    {
                        extend: 'excel',
                        text: '📊 Excel'
                    },
                    {
                        extend: 'pdf',
                        text: '📕 PDF'
                    },
                    {
                        extend: 'print',
                        text: '🖨️ طباعة'
                    },
                    {
                        extend: 'colvis',
                        text: '👁️ عرض الأعمدة'
                    }
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                columnDefs: [{
                    className: 'dtr-control',
                    orderable: false,
                    targets: -1
                }]
            });
            responsive: true
        });
    </script>
@endpush
