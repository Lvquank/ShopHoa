@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách danh mục</h4>
                        {{-- Sửa lại route cho đúng với web.php --}}
                        <a href="{{ route('admin.category.product.add')}}" class="btn btn-success rounded-0 ms-auto py-1">Thêm danh mục</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <th>Đường dẫn (Alias)</th>
                                        <th>Số kiểu dáng</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <th>Đường dẫn (Alias)</th>
                                        <th>Số kiểu dáng</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    {{-- Sử dụng biến $categories mới --}}
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->alias }}</td>
                                            <td>{{ $category->styles_count }}</td> {{-- Hiển thị số style liên quan --}}
                                            <td>
                                                <input class="form-check-input category-status" type="checkbox"
                                                    id="status-{{ $category->id }}" {{ $category->status ? 'checked' : '' }}
                                                    data-category-id="{{ $category->id }}" />
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    {{-- Sửa lại route cho đúng với web.php --}}
                                                    <a href="{{ route('admin.category.product.edit', $category->id) }}"
                                                        class="me-3">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Sửa
                                                    </a>
                                                    {{-- Sửa lại form xóa để sử dụng URL thay vì route không tồn tại --}}
                                                    <form action="{{ url('/admin/danh-muc-san-pham/xoa-danh-muc/' . $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                                        @csrf
                                                        <button type="submit" class="text-danger border-0 bg-transparent">
                                                            <i class="bi bi-trash3"></i>
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.category-status').change(function () {
                var categoryId = $(this).data('category-id');
                var status = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('admin.category.product.change-status')}}", // Sửa lại tên route
                    method: 'POST',
                    data: {
                        id: categoryId,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                             Toast.fire({ icon: "success", text: 'Cập nhật trạng thái thành công!' });
                        }
                    },
                    error: function () {
                        Toast.fire({ icon: "error", text: 'Có lỗi xảy ra!' });
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Toast.fire({
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000,
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: '{{ session('error') }}',
                timer: 3000,
            });
        </script>
    @endif
@endsection
