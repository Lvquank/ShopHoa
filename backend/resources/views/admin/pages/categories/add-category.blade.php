@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- BƯỚC 1: THÊM id VÀ CÁC THUỘC TÍNH data-action-* VÀO FORM --}}
                <form id="creation-form" 
                      action="{{ route('admin.styles.store') }}" 
                      method="post"
                      data-action-style="{{ route('admin.styles.store') }}"
                      data-action-category="{{ route('admin.category.product.store') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Thêm Mới</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-7">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Tùy chọn</label>
                                        <select class="form-select form-control rounded-0" id="category_select" name="category_id">
                                            <option value="0">-- Tạo Danh Mục Mới --</option>
                                            
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" selected>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" id="name_label">Tên Kiểu Dáng <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="name_input"
                                            name="name" value="{{ old('name') }}" required />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Trường alias cho Danh mục, sẽ được ẩn/hiện tự động --}}
                                <div class="col-12" id="category_alias_field">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="category_alias_input">Đường dẫn (alias) Danh Mục <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="category_alias_input"
                                            name="category_alias" value="{{ old('category_alias') }}" />
                                        @error('category_alias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                {{-- Trường alias này dành cho Kiểu dáng, sẽ được ẩn/hiện tự động --}}
                                <div class="col-12" id="style_alias_field">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold" for="alias_style">Đường dẫn (alias) Kiểu Dáng <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="alias_style"
                                            name="alias" value="{{ old('alias') }}" />
                                        @error('alias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{-- BƯỚC 2: CẬP NHẬT TOÀN BỘ SCRIPT ĐỂ XỬ LÝ VIỆC THAY ĐỔI ACTION --}}
<script>
$(document).ready(function() {
    // Lấy các đối tượng cần thiết một lần khi trang tải
    const creationForm = $('#creation-form');
    const categorySelect = $('#category_select');
    
    // Lấy các URL đã lưu trong thuộc tính data-* của form
    const actionStyleUrl = creationForm.data('action-style');
    const actionCategoryUrl = creationForm.data('action-category');

    function updateFormBehavior() {
        var selectedValue = categorySelect.val();

        if (selectedValue == '0') {
            // KHI TẠO DANH MỤC MỚI
            // 1. Hướng form đến CategoryController
            creationForm.attr('action', actionCategoryUrl);

            // 2. Thay đổi giao diện
            $('#name_label').html('Tên Danh Mục Mới <span class="text-danger">(*)</span>');
            $('#style_alias_field').hide();
            $('#alias_style').prop('required', false);
            $('#category_alias_field').show();
            $('#category_alias_input').prop('required', true);

        } else {
            // KHI CHỌN DANH MỤC CÓ SẴN (để tạo kiểu dáng)
            // 1. Hướng form đến StyleController
            creationForm.attr('action', actionStyleUrl);

            // 2. Thay đổi giao diện
            $('#name_label').html('Tên Kiểu Dáng <span class="text-danger">(*)</span>');
            $('#style_alias_field').show();
            $('#alias_style').prop('required', true);
            $('#category_alias_field').hide();
            $('#category_alias_input').prop('required', false);
        }
    }

    // Gọi hàm khi trang tải lần đầu để đảm bảo trạng thái đúng
    updateFormBehavior();

    // Gọi hàm mỗi khi người dùng thay đổi lựa chọn trong dropdown
    categorySelect.change(updateFormBehavior);
});
</script>
@endsection