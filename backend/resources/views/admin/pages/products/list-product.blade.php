@extends('admin.index')

@section('content')
    <div class="page-inner">
        <form action="{{ route('admin.product') }}" method="GET">
            <nav class="navbar navbar-expand-xxl mb-3" style="background: white">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Danh mục</label>
                                    <select class="form-select form-control-sm rounded-0" name="category_id">
                                        <option value="">Tất cả</option>
                                        @if (isset($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Kiểu dáng</label>
                                    <select class="form-select form-control-sm rounded-0" name="style_id">
                                        <option value="">Tất cả</option>
                                        @if (isset($styles))
                                            @foreach ($styles as $style)
                                                <option value="{{ $style->id }}"
                                                        {{ request('style_id') == $style->id ? 'selected' : '' }}>
                                                    {{ $style->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Từ khóa tìm kiếm</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title"
                                           value="{{ request('title') }}" />
                                </div>
                            </div>
                            <div class="nav-link">
                                <div class="form-group">
                                    <label class="text-dark fw-bold">Số dòng hiển thị</label>
                                    <select class="form-select form-control-sm rounded-0" name="per_page">
                                        @foreach ([10, 25, 50, 100] as $option)
                                            <option value="{{ $option }}"
                                                    {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="nav-link d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title">Danh sách sản phẩm ({{ $products->total() }})</h4>
                        <a href="{{ route('admin.product.add') }}" class="btn btn-success rounded-0 ms-auto py-1">Thêm sản
                            phẩm</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Lượt mua</th>
                                        <th>Tình trạng</th>
                                        <th>Nổi bật</th>
                                        <th>Mới</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->product_code }}</td>
                                            <td>
                                                {{-- Sửa: Bỏ dấu / thừa, dùng asset() trực tiếp --}}
                                                <img src="{{ asset($product->image) }}" width="50px"
                                                     alt="{{ $product->title }}">
                                            </td>
                                            <td>
                                                {{ $product->title }}
                                                @if($product->category)
                                                    <p class="small text-muted mb-0">Danh mục: {{ $product->category->name }}</p>
                                                @endif
                                                @if($product->style)
                                                     <p class="small text-muted mb-0">Kiểu dáng: {{ $product->style->name }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($product->price, 0, ',', '.') . '₫' }}
                                            </td>
                                            <td>{{ $product->purchases }}</td>
                                            <td>
                                                {{-- Cải tiến: Hiển thị tình trạng kho bằng màu sắc --}}
                                                @if($product->stock_status == 'instock')
                                                    <span class="badge bg-success">Còn hàng</span>
                                                @elseif($product->stock_status == 'outstock')
                                                    <span class="badge bg-danger">Hết hàng</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Chờ hàng</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input class="form-check-input status" type="checkbox" role="switch"
                                                       {{ $product->is_on_top ? 'checked' : '' }}
                                                       data-id="{{ $product->id }}" data-type="is_on_top">
                                            </td>
                                            <td>
                                                <input class="form-check-input status" type="checkbox" role="switch"
                                                       {{ $product->is_new ? 'checked' : '' }}
                                                       data-id="{{ $product->id }}" data-type="is_new">
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item"
                                                                onclick="showDetailproduct({{ $product->id }})">Xem chi tiết</button>
                                                        
                                                        {{-- Sửa: Dùng Route Model Binding cho nhất quán --}}
                                                        <a class="dropdown-item" href="{{ route('admin.product.edit', $product) }}">Chỉnh sửa</a>
                                                        
                                                        {{-- Sửa: Truyền cả URL được tạo từ route vào hàm onclick --}}
                                                        <button class="dropdown-item text-danger"
                                                                onclick="deleteProduct({{ $product }}, '{{ route('admin.product.delete', $product) }}')">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->appends(request()->all())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Chi tiết sản phẩm --}}
    <div class="modal fade" id="detailProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailProductBody">
                    {{-- Nội dung chi tiết sẽ được load vào đây bằng AJAX --}}
                    <p class="text-center">Đang tải...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bổ sung: Modal Xóa sản phẩm hoàn chỉnh --}}
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteProduct">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Xác nhận xóa sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>
                        <p>Hành động này không thể hoàn tác.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        </script>
    @endif

    {{-- Bổ sung: Các hàm JavaScript cần thiết --}}
    <script>
        // Hàm xóa sản phẩm
        function deleteProduct(product, deleteUrl) {
            document.getElementById('messageDelete').innerHTML = `Bạn có chắc chắn muốn xóa sản phẩm <b>"${product.title}"</b> không?`;
            document.getElementById('formDeleteProduct').action = deleteUrl;
            $('#deleteProductModal').modal('show');
        }

        // Hàm xem chi tiết sản phẩm (cần bạn tự hoàn thiện logic hiển thị)
        function showDetailproduct(productId) {
            const detailBody = $('#detailProductBody');
            detailBody.html('<p class="text-center">Đang tải...</p>'); // Reset nội dung
            $('#detailProductModal').modal('show');
            
            // Gọi AJAX để lấy dữ liệu
            $.ajax({
                url: `/admin/san-pham/json/${productId}`, // URL trỏ đến route getProductJson
                type: 'GET',
                success: function(response) {
                    if(response.error) {
                        detailBody.html(`<p class="text-danger">${response.error}</p>`);
                        return;
                    }
                    // Bạn cần tự định dạng cách hiển thị dữ liệu sản phẩm ở đây
                    const product = response.product;
                    let content = `
                        <h5>${product.title}</h5>
                        <p><strong>Mã sản phẩm:</strong> ${product.product_code}</p>
                        <p><strong>Giá:</strong> ${product.price.toLocaleString('vi-VN')}₫</p>
                        <hr>
                        <h6>Mô tả ngắn:</h6>
                        <div>${product.description || 'Không có'}</div>
                    `;
                    // Thêm logic để hiển thị ảnh chi tiết nếu có
                    if(product.details && product.details.length > 0) {
                        content += `<hr><h6>Nội dung chi tiết:</h6><div>${product.details[0].description}</div>`;
                    }
                    detailBody.html(content);
                },
                error: function() {
                    detailBody.html('<p class="text-center text-danger">Đã có lỗi xảy ra khi tải dữ liệu.</p>');
                }
            });
        }

        $(document).ready(function() {
            // Script cho nút gạt thay đổi status
            $('.status').change(function() {
                var productId = $(this).data('id');
                var type = $(this).data('type');
                var status = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('admin.product.change-status') }}",
                    method: 'POST',
                    data: {
                        id: productId,
                        type: type,
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({ icon: 'success', title: 'Cập nhật trạng thái thành công!' });
                        } else {
                            Toast.fire({ icon: 'error', title: 'Cập nhật thất bại!' });
                        }
                    },
                    error: function() {
                        Toast.fire({ icon: 'error', title: 'Đã có lỗi xảy ra!' });
                    }
                });
            });
        });
    </script>
@endsection