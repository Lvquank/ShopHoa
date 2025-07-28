@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.post.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thông tin bài viết</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-post">Tiêu đề <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                       id="title-post" name="title" value="{{ old('title')}}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- ====================================================== --}}
                                        {{-- THÊM MỚI: Ô nhập liệu cho tác giả --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="author">Tên tác giả <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                       id="author" name="author" value="{{ old('author')}}" />
                                                @error('author')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- ====================================================== --}}

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục<span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="post_category_id">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO)</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                       id="title-seo" name="title_seo" value="{{ old('title_seo')}}" />
                                                @error('title_seo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="description">Mô tả ngắn</label>
                                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description')}}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Nội dung chi tiết</label>
                                                <textarea name="content" id="content">{{ old('content')}}</textarea>
                                                @error('content')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold">Trạng thái</div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    {{-- Input này tương ứng với cột `is_featured` trong bảng posts --}}
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                           id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Bài viết nổi bật
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="image">Ảnh đại diện <span
                                                class="text-danger">(*)</span></label>
                                        <div class="my-2 box-preview" id="homeImagePreview"></div>
                                        <div class="input-group">
                                            <input type="file" class="form-control rounded-0" id="image"
                                                   name="image" onchange="previewHomeImage()" />
                                        </div>
                                         @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Phần mới cho thư viện ảnh --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="gallery-images">Thư viện ảnh</label>
                                        <div class="input-group">
                                            {{-- `images[]` để nhận nhiều file --}}
                                            <input type="file" class="form-control rounded-0" id="gallery-images"
                                                   name="images[]" multiple />
                                        </div>
                                        <div class="my-2 d-flex flex-wrap gap-2" id="gallery-preview">
                                            {{-- Ảnh preview sẽ hiện ở đây --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.post') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success">Lưu bài viết</button>
                        </div>
                    </div>

                </form>
                @if ($errors->any())
    <div class="alert alert-danger">
        <strong class="fw-bold">Có lỗi xảy ra, vui lòng kiểm tra lại!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            // Tự động điền Title SEO từ Tiêu đề bài viết
            $('#title-post').on('input', function () {
                var nameValue = $(this).val();
                $('#title-seo').val(nameValue);
            });
        });
    </script>

    <script>
        CKEDITOR.replace('content', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token() )}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token() )}}",
            filebrowserUploadMethod: 'form'
        });
    </script>

    <script>
        // Xem trước ảnh đại diện
        function previewHomeImage() {
            const fileInput = document.getElementById('image');
            const imagePreview = document.getElementById('homeImagePreview');
            imagePreview.innerHTML = '';
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="img-preview" />`;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        // Xem trước thư viện ảnh
        document.getElementById('gallery-images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('gallery-preview');
            previewContainer.innerHTML = ''; // Xóa ảnh cũ
            const files = event.target.files;
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('img-preview');
                    previewContainer.appendChild(imgElement);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <style>
        .img-preview {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            border: 1px solid #ddd;
            padding: 5px;
            margin-top: 10px;
        }
        #gallery-preview .img-preview {
            max-width: 100px; /* Kích thước nhỏ hơn cho ảnh gallery */
            max-height: 100px;
        }
    </style>
@endsection