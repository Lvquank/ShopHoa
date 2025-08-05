@extends('admin.index')

{{-- BƯỚC 1: Đẩy CSS lên layout chính bằng @push --}}
@push('styles')
<style>
    .select2-results__option--selected .select2-checkbox::after {
        content: "✔";
        color: #0d6efd;
        font-weight: bold;
        position: absolute;
        top: -4px;
        left: 2px;
    }

    .select2-checkbox {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 1px solid #aaa;
        border-radius: 3px;
        margin-right: 8px;
        vertical-align: middle;
        position: relative;
    }
</style>
@endpush


@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.styles.update', ['style' => $style->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Sửa Kiểu Dáng</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Tên Kiểu Dáng <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" name="name"
                                            value="{{ old('name', $style->name) }}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Đường dẫn (alias) <span
                                                class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control form-control rounded-0" name="alias"
                                            value="{{ old('alias', $style->alias) }}" />
                                        @error('alias')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thứ tự <span
                                                class="text-danger">(*)</span></label>
                                        <input type="number" class="form-control form-control rounded-0" name="order"
                                            value="{{ old('order', $style->order) }}" />
                                        @error('order')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="text-dark fw-bold">Thuộc về các danh mục</label>
                                        <select name="category_ids[]" id="categories-select" class="form-select" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, $currentCategoryIds) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-action text-end">
                            <a href="{{ route('admin.styles.index') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function formatCategory(category) {
                if (!category.id) {
                    return category.text;
                }
                var $category = $(
                    '<span><span class="select2-checkbox"></span> ' + category.text + '</span>'
                );
                return $category;
            }

            $('#categories-select').select2({
                placeholder: "Chọn các danh mục",
                allowClear: true,
                theme: "classic",
                closeOnSelect: false,
                templateResult: formatCategory,
                hideSelected: true
            });
        });
    </script>
@endsection