@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- Sửa lại tên các trường cho đúng với DB và route --}}
                <form action="{{ route('admin.product.update', ['productId' => $product->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Sử dụng @method('POST') vì route của bạn là POST, không phải PUT/PATCH --}}
                    <input type="hidden" name="id" value="{{ $product->id}}">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa sản phẩm: {{ $product->title }}</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="name-product">Tên sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="name-product" name="title"
                                                    value="{{ old('title', $product->title)}}" />
                                                @error('title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="alias-product">Đường dẫn liên kết
                                                    <span class="text-danger">(*)</span></label>
                                                <small><i>(Đường dẫn không có khoảng cách, thay khoảng khách bằng dấu - .
                                                        VD:
                                                        danh-muc-san-pham)</i></small>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="alias-product" name="alias"
                                                    value="{{ old('alias', $product->alias)}}" />
                                                @error('alias')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price" value="{{ old('price', $product->price)}}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Giá khuyến mãi</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control form-control rounded-0"
                                                        name="price_sale"
                                                        value="{{ old('price_sale', $product->price_sale)}}" />
                                                    <span class="input-group-text">đ</span>
                                                </div>
                                                @error('price_sale')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Thuộc danh mục sản phẩm <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="category_id" id="category_id">
                                                     <option value="">-- Chọn danh mục --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{$category->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Kiểu dáng <span
                                                        class="text-danger">(*)</span></label>
                                                <select class="form-select form-control rounded-0" name="style_id" id="style_id">
                                                    <option value="">-- Vui lòng chọn danh mục trước --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="home-image">Ảnh minh họa <span
                                                        class="text-danger">(*)</span></label>
                                                <div class="my-2 box-preview" id="homeImagePreview">
                                                    @if($product->image)
                                                    <img class="img-preview"
                                                        src="{{ asset($product->image) }}" alt="">
                                                    @endif
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control rounded-0" id="home-image"
                                                        name="image" onchange="previewHomeImage()" />
                                                    <button class="input-group-text btn btn-outline-danger" type="button"
                                                        id="deleteHomeImage" {{ !$product->image ? 'disabled' : '' }}><i
                                                            class="bi bi-trash3-fill"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Ảnh chi tiết</label>
                                                <div id="existing-images" class="row mb-3">
                                                    @if($product->detailImages)
                                                        @foreach($product->detailImages as $image)
                                                            <div class="col-4 col-md-3 mb-3 existing-image-item"
                                                                data-id="{{ $image->id }}">
                                                                <img class="img-thumbnail w-100"
                                                                    src="{{ asset($image->image) }}" alt="">
                                                                <button type="button"
                                                                    class="btn btn-danger text-white rounded-0 w-100 delete-existing-image"><i
                                                                        class="bi bi-trash3-fill"></i></button>
                                                                <input type="hidden" name="existing_images[{{ $image->id }}]" value="1">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div id="image-preview" class="row mb-3"></div>
                                                <label class="btn btn-primary text-white rounded-0">
                                                    <i class="bi bi-card-image"></i> Thêm ảnh
                                                    <input class="d-none" type="file"
                                                        accept="image/png, image/jpeg, image/gif" name="images[]"
                                                        id="images" multiple>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold" for="title-seo">Title (SEO)</label>
                                                <input type="text" class="form-control form-control rounded-0"
                                                    id="title-seo" name="tag"
                                                    value="{{ old('tag', $product->tag)}}" />
                                                @error('tag')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-dark fw-bold">Mô tả sản phẩm </label>
                                                <textarea name="description" id="description">{{ old('description', $product->description)}}</textarea>
                                                @error('description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border-left: 1px solid rgb(226, 226, 226)">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự hiển thị</label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $product->order ?? 0)}}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header fw-bold" style="background-color: rgb(239, 239, 239)">
                                                Trạng thái hiển thị
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_on_top"
                                                        name="is_on_top" {{ old('is_on_top', $product->is_on_top) ? 'checked' : '' }} />
                                                    <label class="form-check-label text-dark fw-bold" for="is_on_top">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        // Slug generation
        $(document).ready(function () {
            function convertToAlias(str) {
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

            $('#name-product').on('input', function () {
                var nameValue = $(this).val();
                var aliasValue = convertToAlias(nameValue);
                $('#alias-product').val(aliasValue);
                $('#title-seo').val(nameValue);
            });
        });

        // CKEditor
        CKEDITOR.replace('description', {
            filebrowserImageUploadUrl: "{{url('admin/uploads-ckeditor?_token=' . csrf_token() )}}",
            filebrowserBrowseUrl: "{{ url('admin/file-browser?_token=' . csrf_token() )}}",
            filebrowserUploadMethod: 'form'
        });

        // Dependent Dropdown
        $(document).ready(function () {
            const allStyles = @json($styles);
            const productStyleId = '{{ old('style_id', $product->style_id) }}';
            const categorySelect = $('#category_id');
            const styleSelect = $('#style_id');

            function updateStyleDropdown() {
                const selectedCategoryId = categorySelect.val();
                styleSelect.empty(); 

                if (!selectedCategoryId) {
                    styleSelect.append('<option value="">-- Vui lòng chọn danh mục trước --</option>');
                    return;
                }
                styleSelect.append('<option value="">-- Chọn kiểu dáng --</option>');

                const filteredStyles = allStyles.filter(style => style.category_id == selectedCategoryId);
                
                filteredStyles.forEach(style => {
                    const option = $('<option></option>').val(style.id).text(style.name);
                    if (style.id == productStyleId) { 
                        option.prop('selected', true);
                    }
                    styleSelect.append(option);
                });
            }

            updateStyleDropdown();
            categorySelect.on('change', function () {
                updateStyleDropdown();
            });
        });

        // Single Image Preview
        function previewHomeImage() {
            var $fileInput = $('#home-image');
            var $imagePreview = $('#homeImagePreview');
            $imagePreview.empty();
            var files = $fileInput[0].files;
            if (files && files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var $img = $('<img>', { src: e.target.result, class: 'img-preview' });
                    $imagePreview.append($img);
                    $('#deleteHomeImage').prop('disabled', false);
                };
                reader.readAsDataURL(files[0]);
            }
        }

        $('#deleteHomeImage').click(function () {
            $('#homeImagePreview').empty();
            $('#home-image').val('');
            $(this).prop('disabled', true);
        });

        // Multiple Images Preview & Management
        $(document).ready(function () {
            $('.delete-existing-image').on('click', function () {
                const item = $(this).closest('.existing-image-item');
                const hiddenInput = item.find('input[name^="existing_images"]');
                item.hide();
                hiddenInput.val('0');
            });

            let dataTransfer = new DataTransfer();

            $('#images').on('change', function (event) {
                const previewContainer = $('#image-preview');
                const files = event.target.files;

                $.each(files, function (index, file) {
                    dataTransfer.items.add(file);
                });

                this.files = dataTransfer.files;

                previewContainer.empty();
                $.each(dataTransfer.files, function (index, file) {
                    if (!file.type.match('image.*')) return;
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = $('<div>').addClass('col-4 col-md-3 mb-3 new-image-item').attr('data-filename', file.name);
                        const img = $('<img>').attr('src', e.target.result).addClass('img-thumbnail w-100');
                        const deleteBtn = $('<button>').attr('type', 'button')
                            .addClass('btn btn-danger text-white rounded-0 w-100')
                            .html('<i class="bi bi-trash3-fill"></i>')
                            .click(function () {
                                const filename = $(this).closest('.new-image-item').data('filename');
                                for (let i = 0; i < dataTransfer.files.length; i++) {
                                    if (dataTransfer.files[i].name === filename) {
                                        dataTransfer.items.remove(i);
                                        break;
                                    }
                                }
                                $('#images')[0].files = dataTransfer.files;
                                $(this).closest('.new-image-item').remove();
                            });
                        div.append(img, deleteBtn);
                        previewContainer.append(div);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection
