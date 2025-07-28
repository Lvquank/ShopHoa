@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Quản lý Kiểu Dáng</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Kiểu Dáng</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh sách Kiểu Dáng</h4>
                            {{-- SỬA LỖI: Đổi tên route thành 'admin.styles.create' cho nhất quán --}}
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
                                        <th>#</th>
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
                                            {{-- Hiển thị tên category, nếu không có sẽ hiển thị 'N/A' --}}
                                            <td>{{ $style->category->name ?? 'N/A' }}</td>
                                            <td>{{ $style->alias }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    {{-- Nút sửa, trỏ đến route 'admin.styles.edit' --}}
                                                    <a href="{{ route('admin.styles.edit', $style->id) }}" data-bs-toggle="tooltip"
                                                        title="Sửa" class="btn btn-link btn-primary btn-lg"
                                                        data-original-title="Edit Task">
                                                        {{-- SỬA LỖI: Đổi icon sang Bootstrap Icons --}}
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    {{-- Form xóa, trỏ đến route 'admin.styles.destroy' --}}
                                                    <form action="{{ route('admin.styles.destroy', $style->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-bs-toggle="tooltip" title="Xóa"
                                                            class="btn btn-link btn-danger" data-original-title="Remove"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                            {{-- SỬA LỖI: Đổi icon sang Bootstrap Icons --}}
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
