@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- Sử dụng Route Model Binding và @method('PUT') cho đúng chuẩn --}}
                <form action="{{ route('admin.product.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa sản phẩm: {{ $product->name }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        {{-- Tên sản phẩm --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="name-product">Tên sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="name-product" name="name"
                                                    value="{{ old('name', $product->name) }}" />
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Đường dẫn (Alias) --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="alias-product">Đường dẫn liên kết
                                                    <span class="text-danger">(*)</span></label>
                                                <small><i>(Nếu bỏ trống, hệ thống sẽ tự tạo từ tên sản phẩm)</i></small>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="alias-product" name="alias"
                                                    value="{{ old('alias', $product->alias) }}" />
                                                @error('alias')
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
                                                        name="price" value="{{ old('price', $product->price) }}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Giá khuyến mãi --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá khuyến mãi</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price_sale"
                                                        value="{{ old('price_sale', $product->price_sale) }}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price_sale')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
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
                                        {{-- Kiểu dáng (Loại) --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Kiểu dáng (Loại) <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="type_id" id="style_select">
                                                    <option value="">-- Vui lòng chọn danh mục trước --</option>
                                                </select>
                                                @error('type_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Ảnh đại diện --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="home-image">Ảnh đại diện</label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                                    @if($product->home_image)
                                                        <img class="img-preview" src="{{ asset($product->home_image) }}" alt="Ảnh đại diện">
                                                    @endif
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="home-image-input" name="home_image">
                                                    <button class="input-group-text btn btn-outline-danger" type="button"
                                                        id="deleteHomeImage" {{ !$product->home_image ? 'disabled' : '' }}><i class="bi bi-trash3-fill"></i></button>
                                                </div>
                                                <input type="hidden" name="delete_home_image" id="delete_home_image_flag" value="0">
                                                @error('home_image')
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
                                        {{-- Keywords --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="keywords">Từ khóa (Keywords)</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="keywords" name="keywords" value="{{ old('keywords', $product->keywords) }}" />
                                                @error('keywords')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    {{-- Mã sản phẩm --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="product_code">Mã sản phẩm</label>
                                        <input type="text" class="form-control form-control rounded-0"
                                            id="product_code" name="product_code"
                                            value="{{ old('product_code', $product->product_code) }}" readonly />
                                        <small><i>(Không thể thay đổi)</i></small>
                                        @error('product_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Tình trạng kho --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Tình trạng kho</label>
                                        <select class="form-select form-control rounded-0" name="stock_status">
                                            <option value="instock" {{ old('stock_status', $product->stock_status) == 'instock' ? 'selected' : '' }}>Còn hàng</option>
                                            <option value="outstock" {{ old('stock_status', $product->stock_status) == 'outstock' ? 'selected' : '' }}>Hết hàng</option>
                                            <option value="onbackorder" {{ old('stock_status', $product->stock_status) == 'onbackorder' ? 'selected' : '' }}>Chờ hàng</option>
                                        </select>
                                        @error('stock_status')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Thứ tự hiển thị --}}
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị</label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $product->order ?? 0) }}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    {{-- Các trạng thái --}}
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái hiển thị
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_featured"
                                                        name="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_featured">
                                                        Sản phẩm nổi bật
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_new"
                                                        name="is_new" {{ old('is_new', $product->is_new) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_new">
                                                        Sản phẩm mới
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_bestseller"
                                                        name="is_bestseller" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_bestseller">
                                                        Sản phẩm bán chạy
                                                    </label>
                                                </div>
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
            // Gợi ý: Việc tạo slug nên được thực hiện ở backend (Controller)
            // dùng Str::slug() để đảm bảo tính nhất quán và bảo mật.
            function convertToSlug(str) {
                str = str.toLowerCase();
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                str = str.replace(/đ/g, "d");
                str = str.replace(/\s+/g, '-');
                str = str.replace(/[^\w\-]+/g, '');
                str = str.replace(/\-\-+/g, '-');
                str = str.replace(/^-+/, '');
                str = str.replace(/-+$/, '');
                return str;
            }
            $('#name-product').on('keyup', function() {
                var nameValue = $(this).val();
                var aliasValue = convertToSlug(nameValue);
                $('#alias-product').val(aliasValue);
            });

            // Dependent Dropdown cho Danh mục -> Kiểu dáng (AJAX)
            const categorySelect = $('#category_select');
            const styleSelect = $('#style_select');
            const initialTypeId = '{{ old('type_id', $product->type_id) }}';

            function updateStyleDropdown(selectedCategoryId) {
                styleSelect.empty().append('<option value="">Đang tải...</option>');

                if (!selectedCategoryId) {
                    styleSelect.empty().append('<option value="">-- Vui lòng chọn danh mục trước --</option>');
                    return;
                }

                $.ajax({
                    // Bạn cần tạo route này trong file routes/web.php
                    // Ví dụ: Route::get('/get-styles-by-category', [YourController::class, 'getStylesByCategory'])->name('admin.getStylesByCategory');
                    url: '{{ route("admin.getStylesByCategory") }}',
                    type: 'GET',
                    data: { category_id: selectedCategoryId },
                    success: function(styles) {
                        styleSelect.empty().append('<option value="">-- Chọn kiểu dáng --</option>');
                        if (styles && styles.length > 0) {
                            styles.forEach(function(style) {
                                const option = $('<option></option>').val(style.id).text(style.name);
                                if (style.id == initialTypeId) {
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

            // Kích hoạt lần đầu khi tải trang nếu đã có danh mục được chọn
            if (categorySelect.val()) {
                updateStyleDropdown(categorySelect.val());
            }

            // Kích hoạt khi người dùng thay đổi danh mục
            categorySelect.on('change', function() {
                updateStyleDropdown($(this).val());
            });

            // Xử lý xem trước và xóa ảnh đại diện
            $('#home-image-input').on('change', function() {
                const fileInput = this;
                const imagePreview = $('#homeImagePreview');
                imagePreview.empty();
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.html('<img class="img-preview" src="' + e.target.result + '">');
                        $('#deleteHomeImage').prop('disabled', false);
                        $('#delete_home_image_flag').val('0'); // Reset cờ xóa nếu chọn ảnh mới
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });

            $('#deleteHomeImage').click(function() {
                $('#homeImagePreview').empty(); // Xóa ảnh xem trước
                $('#home-image-input').val(''); // Xóa file đã chọn trong input
                $(this).prop('disabled', true); // Vô hiệu hóa nút xóa
                $('#delete_home_image_flag').val('1'); // Đặt cờ để báo cho backend biết cần xóa ảnh
            });
        });
    </script>
@endsection