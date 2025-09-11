@extends('Layouts.dash')

@section('title', 'المنتجات')

@section('content')
    <div class="container-fluid">

        <!-- العنوان الرئيسي -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-5 mb-4 gap-2">
            <h3 class="fw-bold">المنتجات</h3>
            <a href="{{ route('products.add') }}" class="btn btn-success btn-lg shadow-sm">
                <i class="bi bi-plus-lg"></i> إضافة منتج
            </a>
        </div>

        <!-- جدول المنتجات داخل بطاقة -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle" id="productsTable">
                        <thead class="table-dark text-center">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">اسم المنتج</th>
                                <th class="text-center">الفئة</th>
                                <th class="text-center">السعر</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->price }} $</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td class="d-flex justify-content-center gap-1 flex-wrap">
                                        <a href="{{ route('dashboard.index', ['section' => 'productDetails', 'id' => $product->id]) }}"
                                            class="btn btn-info btn-sm shadow-sm" title="عرض التفاصيل">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-warning btn-sm shadow-sm" title="تعديل المنتج">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('products.remove', $product->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                                title="حذف المنتج">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            $('#productsTable').DataTable({
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
