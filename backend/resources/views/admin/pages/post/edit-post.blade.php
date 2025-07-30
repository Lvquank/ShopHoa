@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- Sử dụng Route Model Binding và @method('PUT') cho đúng chuẩn --}}
                <form action="{{ route('admin.post.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa bài viết: {{ $post->title }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        {{-- Tiêu đề --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-post">Tiêu đề <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-post" name="title" value="{{ old('title', $post->title)}}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Tác giả --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="author-post">Tác giả</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="author-post" name="author" value="{{ old('author', $post->author)}}" />
                                                @error('author')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Danh mục --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục<span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="post_category_id">
                                                    <option value="">-- Chọn danh mục --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('post_category_id', $post->post_category_id) == $category->id ? 'selected' : ''}}>
                                                            {{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('post_category_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Ảnh minh họa --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="image">Ảnh minh họa</label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                                    @if($post->image)
                                                        <img class="img-preview" src="{{ asset($post->image) }}" alt="Ảnh minh họa">
                                                    @endif
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="image"
                                                        name="image" />
                                                    <button class="input-group-text btn btn-outline-danger" type="button"
                                                        id="deleteHomeImage" {{ !$post->image ? 'disabled' : '' }}><i class="bi bi-trash3-fill"></i></button>
                                                </div>
                                                <input type="hidden" name="delete_image" id="delete_image_flag" value="0">
                                            </div>
                                        </div>
                                        {{-- Title SEO --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO)</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-seo" name="title_seo" value="{{ old('title_seo', $post->title_seo)}}" />
                                                @error('title_seo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Giới thiệu ngắn --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="content">Giới thiệu ngắn gọn (Content)</label>
                                                <textarea class="form-control rounded-0" rows="4"
                                                    id="content" name="content">{{ old('content', $post->content)}}</textarea>
                                                @error('content')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Nội dung chi tiết --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Nội dung chi tiết (Description)</label>
                                                <textarea name="description" id="description_editor">
                                                    {{ old('description', $post->description)}}
                                                </textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    {{-- Thứ tự hiển thị --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $post->order ?? 0)}}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Trạng thái --}}
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái hiển thị
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="status"
                                                        name="status" {{ old('status', $post->status) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="status">
                                                        Hiển thị
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_featured" name="is_featured" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}/>
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Bài viết nổi bật
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.post') }}" class="btn btn-danger">Quay lại</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            // Tự động điền Title SEO từ Tiêu đề bài viết
            $('#title-post').on('input', function () {
                $('#title-seo').val($(this).val());
            });

            // Khởi tạo CKEditor
            CKEDITOR.replace('description_editor');

            // Xem trước ảnh
            $('#image').on('change', function() {
                const file = this.files[0];
                const imagePreview = $('#homeImagePreview');
                imagePreview.empty();
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.html(`<img class="img-preview" src="${e.target.result}" alt="Ảnh xem trước">`);
                        $('#deleteHomeImage').prop('disabled', false);
                        $('#delete_image_flag').val('0'); // Reset cờ xóa nếu người dùng chọn ảnh mới
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Xử lý nút xóa ảnh
            $('#deleteHomeImage').click(function () {
                $('#homeImagePreview').empty();
                $('#image').val('');
                $(this).prop('disabled', true);
                $('#delete_image_flag').val('1'); // Đặt cờ để báo cho backend biết cần xóa ảnh
            });
        });
    </script>
@endsection