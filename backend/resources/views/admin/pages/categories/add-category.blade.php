@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                {{-- Form action vẫn trỏ đến store của Style, logic sẽ được xử lý trong controller --}}
                <form action="{{ route('admin.styles.store') }}" method="post">
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
                                            {{-- THÊM MỚI: Option để tạo danh mục mới --}}
                                            <option value="0">-- Tạo Danh Mục Mới --</option>
                                            
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" selected>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        {{-- Label này sẽ tự động thay đổi --}}
                                        <label class="text-dark fw-bold" id="name_label">Tên Kiểu Dáng <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" id="name_input"
                                            name="name" value="{{ old('name') }}" required />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- THÊM MỚI: Trường alias cho Danh mục, sẽ được ẩn/hiện tự động --}}
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
<script>
    // Script để thay đổi giao diện một cách thông minh
    $(document).ready(function() {
        function toggleFields() {
            var selectedValue = $('#category_select').val();
            if (selectedValue == '0') {
                // Khi chọn "Tạo Danh Mục Mới"
                $('#name_label').html('Tên Danh Mục Mới <span class="text-danger">(*)</span>');
                
                // Ẩn trường alias của Style
                $('#style_alias_field').hide();
                $('#alias_style').prop('required', false);

                // Hiện trường alias của Category
                $('#category_alias_field').show();
                $('#category_alias_input').prop('required', true);

            } else {
                // Khi chọn một danh mục có sẵn để thêm kiểu dáng
                $('#name_label').html('Tên Kiểu Dáng <span class="text-danger">(*)</span>');
                
                // Hiện lại trường alias của Style
                $('#style_alias_field').show();
                $('#alias_style').prop('required', true);

                // Ẩn trường alias của Category
                $('#category_alias_field').hide();
                $('#category_alias_input').prop('required', false);
            }
        }

        // Gọi hàm khi trang tải lần đầu
        toggleFields();

        // Gọi hàm mỗi khi người dùng thay đổi lựa chọn
        $('#category_select').change(toggleFields);
    });
</script>
@endsection
