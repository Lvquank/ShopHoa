@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title">Danh Sách Danh Mục</h4>
                        <a href="{{ route('admin.category.product.add') }}" class="btn btn-primary rounded-0 ms-auto py-2">
                            <i class="bi bi-plus-lg"></i> Thêm Danh Mục
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Thứ tự</th>
                                        <th>Tên danh mục</th>
                                        <th>Đường dẫn (Alias)</th>
                                        <th>Số kiểu dáng</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->order }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->alias }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->styles_count }}</span>
                                            </td>
                                            <td>
                                                <input class="form-check-input category-status" type="checkbox"
                                                    id="status-{{ $category->id }}" {{ $category->status ? 'checked' : '' }}
                                                    data-category-id="{{ $category->id }}" />
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                     <a href="{{ route('admin.category.product.edit', $category->id) }}" data-bs-toggle="tooltip"
                                                        title="Sửa" class="btn btn-link btn-primary btn-lg">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('admin.category.product.delete', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-bs-toggle="tooltip" title="Xóa"
                                                            class="btn btn-link btn-danger">
                                                            <i class="bi bi-trash3"></i>
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
            // Script cho nút gạt status của category
            $('.category-status').change(function () {
                var categoryId = $(this).data('category-id');
                var status = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('admin.category.product.change-status') }}",
                    method: 'POST',
                    data: {
                        id: categoryId,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        Toast.fire({ icon: "success", text: 'Cập nhật trạng thái thành công!' });
                    },
                    error: function () {
                        Toast.fire({ icon: "error", text: 'Có lỗi xảy ra!' });
                    }
                });
            });
        });
    </script>

    {{-- Hiển thị thông báo session (nếu có) --}}
    @if (session('success'))
        <script>
            Toast.fire({ icon: "success", text: '{{ session('success') }}', timer: 3000 });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({ icon: "error", text: '{{ session('error') }}', timer: 3000 });
        </script>
    @endif
@endsection