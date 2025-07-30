@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh sách Kiểu Dáng</h4>
                            {{-- Sửa: Đổi tên route thành 'admin.styles.create' --}}
                            <a href="{{ route('admin.styles.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm Mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Thứ tự</th>
                                        <th>Tên Kiểu Dáng</th>
                                        <th>Thuộc Danh Mục</th>
                                        <th>Alias</th>
                                        <th style="width: 10%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($styles as $key => $style)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $style->name }}</td>
                                            
                                            {{-- SỬA LỖI: Lặp qua danh sách categories và hiển thị --}}
                                            <td>
                                                @forelse($style->categories as $category)
                                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                                @empty
                                                    <span class="badge bg-danger">Chưa có</span>
                                                @endforelse
                                            </td>
                                            
                                            <td>{{ $style->alias }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    {{-- Sửa: Trỏ đến route 'admin.styles.edit' --}}
                                                    <a href="{{ route('admin.category.product.edit', $style->id) }}" data-bs-toggle="tooltip"
                                                        title="Sửa" class="btn btn-link btn-primary btn-lg">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    {{-- Sửa: Form xóa trỏ đến 'admin.styles.destroy' --}}
                                                    <form action="{{ route('admin.category.product.delete', $style->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-bs-toggle="tooltip" title="Xóa"
                                                            class="btn btn-link btn-danger">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Hiển thị các nút phân trang --}}
                        <div class="mt-3">
                            {{ $styles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection