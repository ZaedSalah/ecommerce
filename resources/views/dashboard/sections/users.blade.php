@extends('Layouts.dash')

@section('title', 'المستخدمون')

@section('content')
    <div class="container-fluid">

        <div class="mb-4 mt-5">
            <h3 class="fw-bold">المستخدمون</h3>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <label>بحث:</label>
                <input type="text" id="search" class="form-control form-control-sm"
                    placeholder="ابحث بالاسم أو البريد الإلكتروني">
            </div>
            <div class="col-md-4 mb-2">
                <label>فلتر حسب الصلاحية:</label>
                <select id="roleFilter" class="form-select form-select-sm">
                    <option value="">كل الصلاحيات</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-sm" id="usersTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th class="role-col">الصلاحية</th>
                        <th>تاريخ الانضمام</th>
                        <th class="actions-col">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="role-cell" data-role="{{ $user->role }}">{{ $user->role }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="actions-cell text-center">
                                <form action="{{ route('dashboard.userRole.update', $user->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-select form-select-sm d-inline"
                                        onchange="this.form.submit()">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>

                                        <option value="admin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Super
                                            Admin</option>
                                    </select>
                                </form>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mt-2"
                                        onclick="return confirm('هل أنت متأكد من حذف المستخدم؟')"><i
                                            class="bi bi-trash"></i></button>
                                </form>
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
        .role-cell {
            text-align: center;
            font-weight: bold;
        }

        @media (max-width: 768px) {

            .role-col,
            .role-cell {
                display: table-cell !important;
            }
        }

        @media print {
            .actions-cell {
                display: none !important;
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

            // إعداد DataTable
            var table = $('#usersTable').DataTable({
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
                            columns: ':not(.actions-col)',
                            rows: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if ($(node).hasClass('role-cell')) {
                                        return $(node).attr('data-role');
                                    }
                                    return data;
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

            // فلترة حسب الصلاحية
            $('#roleFilter').on('change', function() {
                var value = $(this).val();
                table.column('.role-col').search(value).draw();
            });

            // فلترة حسب البحث
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });

        });
    </script>
@endpush
