@extends('admin.index')

@section('content')
    {{--
        LƯU Ý QUAN TRỌNG:
        Controller của bạn (trong hàm addProduct) cần truyền 2 biến vào view này:
        1. $categories = Category::all();
        2. $styles = Style::all();
    --}}
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm sản phẩm mới</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Cột chính bên trái --}}
                                <div class="col-md-8">
                                    <div class="row">
                                        {{-- Tên sản phẩm --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-product">Tên sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-product" name="title" value="{{ old('title') }}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Giá sản phẩm --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price" value="{{ old('price', 0) }}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Thứ tự hiển thị --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thứ tự hiển thị</label>
                                                <input type="number" class="form-control form-control rounded-0"
                                                    name="order" value="{{ old('order', 0) }}" />
                                                @error('order')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Mô tả sản phẩm --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả sản phẩm</label>
                                                <textarea name="description" id="description">
                                                    {{ old('description') }}
                                                </textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Cột phụ bên phải --}}
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    {{-- Danh mục sản phẩm --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Danh mục sản phẩm <span
                                                class="text-danger">(*)</span></label>
                                        <select class="form-select form-control rounded-0" name="category_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Kiểu dáng sản phẩm --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Kiểu dáng sản phẩm</label>
                                        <select class="form-select form-control rounded-0" name="style_id">
                                            <option value="">-- Chọn kiểu dáng --</option>
                                            @foreach ($styles as $style)
                                                <option value="{{ $style->id }}" {{ old('style_id') == $style->id ? 'selected' : '' }}>{{ $style->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Thẻ (Tags) --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thẻ (Tags)</label>
                                        <input type="text" class="form-control form-control rounded-0" name="tag"
                                            value="{{ old('tag') }}" placeholder="Ví dụ: hoa sinh nhật, hoa 20-10" />
                                    </div>
                                    
                                    {{-- Ảnh minh họa --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="image-input">Ảnh minh họa <span
                                                class="text-danger">(*)</span></label>
                                        <div class="my-2 box-preview" id="imagePreview"></div>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control rounded-0" id="image-input"
                                                name="image" onchange="previewImage()" />
                                            <button class="input-group-text btn btn-outline-danger" type="button"
                                                id="deleteImage" disabled><i class="bi bi-trash3-fill"></i></button>
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Các trạng thái --}}
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_on_top" name="is_on_top" {{ old('is_on_top') ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_on_top">
                                                        Sản phẩm nổi bật
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_new" name="is_new" checked />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.product') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Script cho CKEditor
        CKEDITOR.replace('description', {
            filebrowserImageUploadUrl: "{{ url('admin/uploads-ckeditor?_token=' . csrf_token()) }}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token()) }}",
            filebrowserUploadMethod: 'form'
        });

        // Script xem trước và xóa ảnh
        function previewImage() {
            var $fileInput = $('#image-input');
            var $imagePreview = $('#imagePreview');
            $imagePreview.empty();
            var file = $fileInput[0].files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var $img = $('<img>', {
                        src: e.target.result,
                        class: 'img-fluid rounded' // Sử dụng class của Bootstrap
                    });
                    $imagePreview.append($img);
                    $('#deleteImage').prop('disabled', false);
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function() {
            $('#deleteImage').click(function() {
                $('#imagePreview').empty();
                $('#image-input').val('');
                $(this).prop('disabled', true);
            });
        });
    </script>
@endsection
