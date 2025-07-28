{{-- resources/views/admin/post-review/list-post-review.blade.php --}}

@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách bình luận bài viết</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover basic-datatables">
                                <thead>
                                    <tr>
                                        <th>Tác giả</th>
                                        <th>Bình luận</th>
                                        <th>Trong bài viết</th>
                                        <th>Thời gian</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Tác giả</th>
                                        <th>Bình luận</th>
                                        <th>Trong bài viết</th>
                                        <th>Thời gian</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>
                                                <strong>{{ $review->name }}</strong>
                                                <br>
                                                <small>{{ $review->email }}</small>
                                            </td>
                                            <td>
                                                {{ $review->comment }}
                                            </td>
                                            <td>
                                                {{-- Giả sử bạn có mối quan hệ 'post' trong Model PostReview --}}
                                                <a href="#">{{ $review->post->title }}</a>
                                            </td>
                                            <td>{{ $review->created_at->format('H:i d/m/Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        {{-- Thay đổi route cho phù hợp --}}
                                                        <a href="{{ route('admin.post-review.edit', ['reviewId' => $review->id])}}" class="dropdown-item">Chỉnh sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deletePostReview({{ $review }})">Xóa</button>
                                                    </div>
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
    <div class="modal fade" id="deletePostReviewModal" tabindex="-1" aria-labelledby="deletePostReviewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeletePostReview">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deletePostReviewLabel">Xác nhận xóa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>Bạn có chắc chắn muốn xóa bình luận này không? Hành động này không thể được hoàn tác.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
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
            Toast.fire({
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000,
            });
        </script>
    @endif

    <script>
        function deletePostReview(review) {
            document.getElementById('messageDelete').innerHTML = `Bạn sắp xóa bình luận của "<strong>${review.name}</strong>".`;
            // Thay đổi action của form đến route xóa bình luận bài viết
            document.getElementById('formDeletePostReview').action = `/admin/post-review/delete/${review.id}`;
            $('#deletePostReviewModal').modal('show');
        }
    </script>
@endsection