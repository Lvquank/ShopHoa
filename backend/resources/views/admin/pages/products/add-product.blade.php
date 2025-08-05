@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
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

                                        {{-- Mô tả ngắn sản phẩm --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả ngắn</label>
                                                <textarea class="form-control rounded-0" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- ====================================================== --}}
                                        {{-- Nội dung chi tiết (product_details) --}}
                                        {{-- ====================================================== --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Nội dung chi tiết sản phẩm</label>
                                                <textarea name="detail_description" id="detail_description_editor">{{ old('detail_description') }}</textarea>
                                                @error('detail_description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- Cột phụ bên phải --}}
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="product_code">Mã sản phẩm <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0"
                                            id="product_code" name="product_code" value="{{ old('product_code') }}" placeholder="Ví dụ: SP001" />
                                        @error('product_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
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
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Tình trạng kho</label>
                                        <select class="form-select form-control rounded-0" name="stock_status">
                                            <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>Còn hàng</option>
                                            <option value="outstock" {{ old('stock_status') == 'outstock' ? 'selected' : '' }}>Hết hàng</option>
                                            <option value="onbackorder" {{ old('stock_status') == 'onbackorder' ? 'selected' : '' }}>Chờ hàng</option>
                                        </select>
                                        @error('stock_status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Thẻ (Tags) --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thẻ (Tags)</label>
                                        <input type="text" class="form-control form-control rounded-0" name="tag"
                                            value="{{ old('tag') }}" placeholder="Ví dụ: hoa sinh nhật, hoa 20-10" />
                                    </div>
                                    
                                    {{-- Ảnh đại diện --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="image-input">Ảnh đại diện <span
                                                class="text-danger">(*)</span></label>
                                        <div class="my-2 box-preview" id="imagePreview"></div>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control rounded-0" id="image-input" name="image" onchange="previewImage()" />
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    {{-- ====================================================== --}}
                                    {{-- Thư viện ảnh chi tiết (product_detail_images) --}}
                                    {{-- ====================================================== --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="gallery-images">Thư viện ảnh chi tiết</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control rounded-0" id="gallery-images"
                                                   name="detail_images[]" multiple />
                                        </div>
                                        <div class="my-2 d-flex flex-wrap gap-2" id="gallery-preview">
                                            {{-- Ảnh preview sẽ hiện ở đây --}}
                                        </div>
                                        @error('detail_images.*')
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
                                                        id="is_new" name="is_new" {{ old('is_new', 1) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                                {{-- ================================================== --}}
                                                {{-- THÊM MỚI: Checkbox cho sản phẩm khuyến mãi (is_sale) --}}
                                                {{-- ================================================== --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="is_sale" name="is_sale" {{ old('is_sale') ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_sale">
                                                        Sản phẩm khuyến mãi
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
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Khởi tạo CKEditor cho mô tả ngắn
        CKEDITOR.replace('description');

        // Khởi tạo CKEditor cho nội dung chi tiết
        CKEDITOR.replace('detail_description_editor');

        // Xem trước ảnh đại diện
        function previewImage() {
            const fileInput = document.getElementById('image-input');
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '';
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="img-preview" />`;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
        
        // Script xem trước thư viện ảnh chi tiết
        document.getElementById('gallery-images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('gallery-preview');
            previewContainer.innerHTML = ''; // Xóa ảnh cũ
            const files = event.target.files;
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('img-preview-small');
                    previewContainer.appendChild(imgElement);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    <style>
        .img-preview { max-width: 100%; height: auto; max-height: 200px; border: 1px solid #ddd; padding: 5px; margin-top: 10px; }
        .img-preview-small { width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 3px; }
    </style>
@endsection