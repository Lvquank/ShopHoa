@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh sách Kiểu Dáng</h4>
                            <a href="{{ route('admin.styles.create') }}" class="btn btn-primary rounded-0 ms-auto py-2">
                                <i class="bi bi-plus-lg"></i>
                                Thêm Kiểu Dáng
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Thứ tự</th>
                                        <th>Tên Kiểu Dáng</th>
                                        <th>Thuộc Danh Mục</th>
                                        <th>Alias</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($styles as $key => $style)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $style->name }}</td>
                                            
                                            <td>
                                                @forelse($style->categories as $category)
                                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                                @empty
                                                    <span class="badge bg-danger">Chưa có</span>
                                                @endforelse
                                            </td>
                                            
                                            <td>{{ $style->alias }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.styles.edit', ['style' => $style->id]) }}" data-bs-toggle="tooltip"
                                                       title="Sửa" class="btn btn-link btn-primary btn-lg p-1">
                                                        <i class="bi bi-pencil-square"></i>
                                                        Sửa
                                                    </a>

                                                    {{-- Nút xóa đã được thay thế để dùng modal --}}
                                                    <button type="button" class="btn btn-link btn-danger p-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteStyleModal"
                                                            data-style-id="{{ $style->id }}"
                                                            data-style-name="{{ $style->name }}"
                                                            data-bs-toggle="tooltip" title="Xóa">
                                                        <i class="bi bi-trash3"></i>
                                                        Xoá
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Hiển thị các nút phân trang --}}
                        <div class="mt-3">
                            {{ $styles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal xác nhận xóa (đã thêm) --}}
    <div class="modal fade" id="deleteStyleModal" tabindex="-1" aria-labelledby="deleteStyleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" id="deleteStyleForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h1 class="modal-title fs-5" id="deleteStyleModalLabel">Xác Nhận Xóa</h1>
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
    {{-- Script xử lý modal và thông báo (đã thêm) --}}
    <script>
        $(document).ready(function() {
            const deleteModal = document.getElementById('deleteStyleModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const styleId = button.getAttribute('data-style-id');
                    const styleName = button.getAttribute('data-style-name');

                    const modalMessage = deleteModal.querySelector('#messageDelete');
                    const deleteForm = deleteModal.querySelector('#deleteStyleForm');

                    modalMessage.textContent = 'Bạn có chắc chắn muốn xóa kiểu dáng "' + styleName + '" không?';

                    // Sử dụng tham số 'style' như trong route của bạn
                    let deleteUrl = "{{ route('admin.styles.destroy', ['style' => ':id']) }}";
                    deleteUrl = deleteUrl.replace(':id', styleId);

                    deleteForm.setAttribute('action', deleteUrl);
                });
            }
        });
    </script>

    {{-- Hiển thị thông báo session (đã thêm) --}}
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