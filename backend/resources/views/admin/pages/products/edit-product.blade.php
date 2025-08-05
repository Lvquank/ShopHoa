@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- SỬA: action trỏ đến route update với đúng tham số 'productId' --}}
                <form action="{{ route('admin.product.update', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            {{-- SỬA: Hiển thị đúng $product->title --}}
                            <div class="card-title">Sửa sản phẩm: {{ $product->title }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        {{-- Tên sản phẩm --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-product">Tên sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                {{-- SỬA: name="title" để khớp với database --}}
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-product" name="title"
                                                    value="{{ old('title', $product->title) }}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- XÓA: Bỏ trường Alias vì không có trong database --}}

                                        {{-- Giá sản phẩm --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price" value="{{ old('price', $product->price) }}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- XÓA: Bỏ trường Giá khuyến mãi vì không có trong database --}}

                                        {{-- Danh mục sản phẩm --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="category_id" id="category_select">
                                                    <option value="">-- Chọn danh mục --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{$category->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Kiểu dáng (Style) --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Kiểu dáng (Style)</label>
                                                {{-- SỬA: name="style_id" để khớp với database --}}
                                                <select class="form-select form-control rounded-0" name="style_id" id="style_select">
                                                    <option value="">-- Vui lòng chọn danh mục trước --</option>
                                                </select>
                                                @error('style_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        {{-- Mô tả --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả sản phẩm</label>
                                                <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Thẻ (Tag) --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="tag">Thẻ (Tags)</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="tag" name="tag" value="{{ old('tag', $product->tag) }}" />
                                                @error('tag')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                     {{-- Ảnh đại diện --}}
                                     <div class="form-group">
                                        <label class="text-dark fw-bold" for="image-input">Ảnh đại diện</label>
                                        <div class="my-2 box-preview" id="imagePreview">
                                            @if($product->image)
                                                <img class="img-preview" src="{{ asset($product->image) }}" alt="Ảnh đại diện">
                                            @endif
                                        </div>
                                        <div class="input-group mb-3">
                                            {{-- SỬA: name="image" để khớp với database --}}
                                            <input type="file" class="form-control rounded-0" id="image-input" name="image">
                                        </div>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Mã sản phẩm --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="product_code">Mã sản phẩm</label>
                                        <input type="text" class="form-control form-control rounded-0"
                                            id="product_code" name="product_code"
                                            value="{{ old('product_code', $product->product_code) }}" readonly />
                                        <small><i>(Không thể thay đổi)</i></small>
                                    </div>
                                    {{-- Tình trạng kho --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Tình trạng kho</label>
                                        <select class="form-select form-control rounded-0" name="stock_status">
                                            <option value="instock" {{ old('stock_status', $product->stock_status) == 'instock' ? 'selected' : '' }}>Còn hàng</option>
                                            <option value="outstock" {{ old('stock_status', $product->stock_status) == 'outstock' ? 'selected' : '' }}>Hết hàng</option>
                                            <option value="onbackorder" {{ old('stock_status', $product->stock_status) == 'onbackorder' ? 'selected' : '' }}>Chờ hàng</option>
                                        </select>
                                    </div>
                                    {{-- Thứ tự hiển thị --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị</label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $product->order ?? 0) }}" />
                                    </div>
                                    {{-- Các trạng thái --}}
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái hiển thị
                                            </div>
                                            <div class="card-body">
                                                {{-- SỬA: is_on_top --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_on_top"
                                                        name="is_on_top" {{ old('is_on_top', $product->is_on_top) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_on_top">
                                                        Sản phẩm ưu tiên
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_new"
                                                        name="is_new" {{ old('is_new', $product->is_new) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                                {{-- THÊM: is_sale --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_sale"
                                                        name="is_sale" {{ old('is_sale', $product->is_sale) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_sale">
                                                        Sản phẩm khuyến mãi
                                                    </label>
                                                </div>
                                                 {{-- XÓA: Bỏ is_featured và is_bestseller --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.product') }}" class="btn btn-danger">Hủy</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        // Khởi tạo CKEditor
        CKEDITOR.replace('description');

        $(document).ready(function() {
            // XÓA: Bỏ script tự tạo alias vì đã bỏ trường alias
            
            // Dependent Dropdown cho Danh mục -> Kiểu dáng (AJAX)
            const categorySelect = $('#category_select');
            const styleSelect = $('#style_select');
            // SỬA: Sửa biến type_id thành style_id
            const initialStyleId = '{{ old('style_id', $product->style_id) }}';

            function updateStyleDropdown(selectedCategoryId) {
                styleSelect.empty().append('<option value="">Đang tải...</option>');

                if (!selectedCategoryId) {
                    styleSelect.empty().append('<option value="">-- Vui lòng chọn danh mục trước --</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route("admin.getStylesByCategory") }}',
                    type: 'GET',
                    data: { category_id: selectedCategoryId },
                    success: function(styles) {
                        styleSelect.empty().append('<option value="">-- Chọn kiểu dáng --</option>');
                        if (styles && styles.length > 0) {
                            styles.forEach(function(style) {
                                const option = $('<option></option>').val(style.id).text(style.name);
                                // SỬA: so sánh với initialStyleId
                                if (style.id == initialStyleId) {
                                    option.prop('selected', true);
                                }
                                styleSelect.append(option);
                            });
                        } else {
                            styleSelect.empty().append('<option value="">-- Không có kiểu dáng --</option>');
                        }
                    },
                    error: function() {
                        styleSelect.empty().append('<option value="">-- Lỗi khi tải dữ liệu --</option>');
                    }
                });
            }

            // Kích hoạt lần đầu khi tải trang
            if (categorySelect.val()) {
                updateStyleDropdown(categorySelect.val());
            }

            // Kích hoạt khi người dùng thay đổi danh mục
            categorySelect.on('change', function() {
                updateStyleDropdown($(this).val());
            });
        });
    </script>
@endsection