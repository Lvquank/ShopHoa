@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.category.product.update', ['category' => $category->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" value="{{ $category->id}}" name="category_id"> --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa danh mục sản phẩm</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="name_category">Tên danh mục sản phẩm <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="name_category"
                                            name="name" value="{{$category->name}}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="alias_category">Đường dẫn liên kết <span
                                                class="text-danger">(*)</span></label>
                                        <small><i>(Đường dẫn không có khoảng cách, thay khoảng khách bằng dấu - . VD:
                                                danh-muc-san-pham)</i></small>
                                        <input type="text" class="form-control form-control rounded-0" id="alias_category"
                                            name="alias" value="{{$category->alias}}" />
                                        @error('alias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="text-dark fw-bold" for="order_category">Thứ tự <span
                                            class="text-danger">(*)</span></label>
                                    <input type="number" class="form-control form-control rounded-0" id="order_category"
                                        name="order" value="{{$category->order}}" />
                                    @error('order')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-8 d-flex align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="status" name="status" {{ $category->status ? 'checked' : '' }} />
                                    <label class="form-check-label text-dark fw-bold" for="status">
                                        Trạng thái hiển thị
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-action text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-count">Quay lại</a>
                        <button type="submit" class="btn btn-success">Sửa</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage() {
            var $fileInput = $('#file');
            var $imagePreview = $('#imagePreview');
            $imagePreview.empty(); // Xóa nội dung cũ
            var files = $fileInput[0].files;
            if (files && files[0]) {
                var file = files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    var $img = $('<img>', {
                        src: e.target.result,
                        class: 'img-preview'
                    });

                    $imagePreview.append($img);
                    $('#deleteImage').prop('disabled', false);
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function () {
            $('#deleteImage').click(function () {
                $('#imagePreview').empty();
                $('#file').val('');
                $(this).prop('disabled', true);
            })
        })
    </script>
@endsection