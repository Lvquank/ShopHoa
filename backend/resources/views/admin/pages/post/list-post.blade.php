@extends('admin.index')

@section('content')
    <div class="page-inner">
        {{-- Sửa: Đổi name="name" thành name="title" cho khớp với Controller --}}
        <form action="{{ route('admin.post')}}" method="GET">
            <nav class="navbar navbar-expand-xxl mb-3" style="background: white">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Danh mục bài viết</label>
                                    <select class="form-select form-control-sm rounded-0" name="post_category_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id}}" {{ request('post_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title"
                                           value="{{ request('title')}}" />
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Số dòng hiển thị</label>
                                    <select class="form-select form-control-sm rounded-0" name="per_page">
                                        @foreach ([10, 25, 50, 100] as $option)
                                            <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách bài viết ({{ $posts->total() }})</h4>
                        <a href="{{ route('admin.post.add')}}" class="btn btn-success rounded-0 ms-auto py-1">Thêm bài viết</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Tiêu đề bài viết</th>
                                        <th>Ngày đăng</th>
                                        <th>Lượt xem</th>
                                        <th>Nổi bật</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($post->image)}}" width="80px" alt="{{$post->title}}">
                                            </td>
                                            <td>
                                                <strong>{{$post->title}}</strong>
                                                <p class="small text-muted mb-0">Tác giả: {{ $post->author }}</p>
                                                @if($post->category)
                                                    <p class="small text-muted mb-0">Danh mục: {{ $post->category->name }}</p>
                                                @endif
                                            </td>
                                            <td>{{ $post->created_at ? $post->created_at->format('d/m/Y H:i') : '' }} </td>
                                            <td>
                                                <span class="fw-bold">{{$post->histotal}}</span>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input status" type="checkbox" {{ $post->is_featured ? 'checked' : '' }} data-id="{{ $post->id }}" data-type="is_featured" />
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        {{-- Sửa: Dùng Route Model Binding, truyền cả đối tượng $post --}}
                                                        <a class="dropdown-item" href="{{ route('admin.post.edit', $post) }}">Chỉnh sửa</a>
                                                        
                                                        {{-- Sửa: Truyền cả URL được tạo từ route vào hàm onclick --}}
                                                        <button class="dropdown-item text-danger"
                                                                onclick="deletePost({{ $post }}, '{{ route('admin.post.delete', $post) }}')">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sửa: Thêm @method('DELETE') vào form và đổi id của modal --}}
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeletePost">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h1 class="modal-title fs-5" id="deletePostLabel">Xác nhận xóa bài viết</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>
                        <p>Hành động này không thể hoàn tác!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({ icon: "success", text: '{{ session('success') }}' });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({ icon: "error", text: '{{ session('error') }}' });
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $('.status').change(function () {
                var postId = $(this).data('id');
                var status = $(this).is(':checked');
                var type = $(this).data('type');
                $.ajax({
                    url: "{{ route('admin.post.change-status')}}",
                    method: 'POST',
                    data: {
                        id: postId,
                        status: status,
                        type: type,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            Toast.fire({ icon: "success", text: 'Cập nhật trạng thái thành công' });
                        } else {
                            Toast.fire({ icon: "error", text: 'Có lỗi khi thay đổi trạng thái' });
                        }
                    }
                });
            });
        });

        // Sửa: Hàm deletePost nhận thêm tham số deleteUrl
        function deletePost(post, deleteUrl) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn muốn xóa bài viết <b>"${post.title}"</b> không?`;
            document.getElementById('formDeletePost').action = deleteUrl;
            $('#deletePostModal').modal('show');
        }
    </script>
@endsection