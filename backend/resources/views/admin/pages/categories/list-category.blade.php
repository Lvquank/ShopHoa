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
                                                       title="Sửa" class="btn btn-link btn-primary btn-lg p-1">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Sửa
                                                    </a>
                                                    
                                                    {{-- Nút này chỉ dùng để mở modal, không submit form --}}
                                                    <button type="button" class="btn btn-link btn-danger p-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteCategoryModal"
                                                            data-category-id="{{ $category->id }}"
                                                            data-category-name="{{ $category->name }}"
                                                            data-bs-toggle="tooltip" title="Xóa">
                                                        <i class="bi bi-trash3"></i>
                                                        Xóa
                                                    </button>
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
    
    {{-- Modal xác nhận xóa --}}
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Form này sẽ được submit khi nhấn nút "Đồng ý Xóa" --}}
            <form method="POST" action="" id="deleteCategoryForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h1 class="modal-title fs-5" id="deleteCategoryModalLabel">Xác Nhận Xóa</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete">Bạn có chắc chắn muốn xóa?</p>
                        <p class="mb-0">Hành động này không thể được hoàn tác.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Đồng ý Xóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Script cho nút gạt status
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

            // === SCRIPT XỬ LÝ MODAL XÓA ===
            const deleteModal = document.getElementById('deleteCategoryModal');
            if (deleteModal) {
                // Lắng nghe sự kiện khi modal được mở
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const categoryId = button.getAttribute('data-category-id');
                    const categoryName = button.getAttribute('data-category-name');

                    const modalMessage = deleteModal.querySelector('#messageDelete');
                    const deleteForm = deleteModal.querySelector('#deleteCategoryForm');

                    modalMessage.textContent = 'Bạn có chắc chắn muốn xóa danh mục "' + categoryName + '" không?';
                    
                    let deleteUrl = "{{ route('admin.category.product.delete', ['categoryId' => ':id']) }}";
                    deleteUrl = deleteUrl.replace(':id', categoryId);

                    deleteForm.setAttribute('action', deleteUrl);
                });
            }
        });
    </script>

    {{-- Hiển thị thông báo session --}}
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