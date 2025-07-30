@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.post.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm bài viết mới</div>
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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="author">Tác giả</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                       id="author" name="author" value="{{ old('author')}}" />
                                                @error('author')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục<span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="post_category_id">
                                                    <option value="">-- Chọn danh mục --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('post_category_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                                <label class="text-dark fw-bold" for="content">Giới thiệu ngắn gọn (Content)</label>
                                                <textarea class="form-control rounded-0" name="content" id="content" rows="4">{{ old('content')}}</textarea>
                                                @error('content')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Nội dung chi tiết (Description)</label>
                                                <textarea name="description" id="description_editor">{{ old('description')}}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị <span class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order" value="{{ old('order', 0) }}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold">Trạng thái</div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ old('status', 1) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="status">
                                                        Hiển thị
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }} />
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
                                    
                                    {{-- ====================================================== --}}
                                    {{-- THÊM LẠI: Phần Thư viện ảnh (images[]) --}}
                                    {{-- ====================================================== --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="gallery-images">Thư viện ảnh</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control rounded-0" id="gallery-images"
                                                   name="images[]" multiple />
                                        </div>
                                        <div class="my-2 d-flex flex-wrap gap-2" id="gallery-preview">
                                            {{-- Ảnh preview sẽ hiện ở đây --}}
                                        </div>
                                        @error('images.*')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.post') }}" class="btn btn-danger">Hủy</a>
                            <button type="submit" class="btn btn-success">Lưu bài viết</button>
                        </div>
                    </div>
                </form>
        </ul>
    </div>
@endif
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
                var nameValue = $(this).val();
                $('#title-seo').val(nameValue);
            });

            // Khởi tạo CKEditor
            CKEDITOR.replace('description_editor', {
                filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token() )}}",
                filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token() )}}",
                filebrowserUploadMethod: 'form'
            });

            // Xem trước ảnh đại diện
            $('#image').on('change', function() {
                const file = this.files[0];
                const imagePreview = $('#homeImagePreview');
                imagePreview.empty();
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.html(`<img src="${e.target.result}" class="img-preview" />`);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // ======================================================
            // THÊM LẠI: Script xem trước Thư viện ảnh
            // ======================================================
            $('#gallery-images').on('change', function(event) {
                const previewContainer = $('#gallery-preview');
                previewContainer.empty();
                const files = event.target.files;
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = $('<img>').attr('src', e.target.result).addClass('img-preview-small');
                        previewContainer.append(imgElement);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <style>
        .img-preview {
            max-width: 100%; height: auto; max-height: 200px;
            border: 1px solid #ddd; padding: 5px; margin-top: 10px;
        }
        .img-preview-small {
            width: 100px; height: 100px; object-fit: cover;
            border: 1px solid #ddd; padding: 3px;
        }
    </style>
@endsection