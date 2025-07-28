{{-- resources/views/admin/post-review/edit-post-review.blade.php --}}

@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- Thay đổi route cho phù hợp --}}
                <form action="{{ route('admin.post-review.update', ['reviewId' => $review->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Chỉnh sửa bình luận bài viết</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Trong bài viết</label>
                                        <input type="text" class="form-control rounded-0" readonly value="{{ $review->post->title }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name">Tên người bình luận <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control rounded-0" id="name" name="name" value="{{ $review->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="email">Email <span class="text-danger">(*)</span></label>
                                        <input type="email" class="form-control rounded-0" id="email" name="email" value="{{ $review->email }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="website">Website</label>
                                        <input type="url" class="form-control rounded-0" id="website" name="website" value="{{ $review->website }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="comment">Bình luận <span class="text-danger">(*)</span></label>
                                        <textarea class="form-control form-control rounded-0" id="comment" name="comment" rows="5" required>{{ $review->comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ route('admin.post-review.list') }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Thêm scripts nếu cần --}}
@endsection