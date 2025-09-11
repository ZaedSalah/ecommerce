@extends('Layouts.master')

@section('content')
    <div class="container my-5">
        <div class="text-right">
            <a href="/addproduct" class="btn btn-primary mb-4 p-3 w-50">
                اضافة المنتج
                <i class="fas fa-plus"></i></a>
        </div>

        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td><img src="{{ $item->imagepath }}" width="100px;" height="100px;"></td>
                        <td>
                            <a href="/removeproduct/{{ $item->id }}" class="btn btn-danger"><i class="fas fa-trash"></i>
                                حذف المنتج </a>
                            <a href="/editproduct/{{ $item->id }}" class="btn btn-success"><i class="fas fa-pen"></i>
                                تعديل المنتج </a>

                            <a href="/AddProductImages/{{ $item->id }}" class="btn btn-dark"><i
                                    class="fas fa-solid fa-image"></i>
                                اضافة صور </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
