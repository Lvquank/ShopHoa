@extends('admin.index')

@section('content')
    {{-- Lưu ý: Controller cần truyền biến $styles và eager-load 'category', 'style' --}}
    {{-- Ví dụ: $products = Product::with(['category', 'style'])->paginate(); --}}
    {{--         $styles = Style::all(); --}}
    {{--         return view('...', compact('products', 'styles')); --}}

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
                                    <label class="text-dark fw-bold">Kiểu dáng</label>
                                    <select class="form-select form-control-sm rounded-0" name="style_id">
                                        <option value="">Tất cả</option>
                                        {{-- Controller cần truyền biến $styles --}}
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
                                                {{ request('per_page') == $option ? 'selected' : '' }}>
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
                                        <th>Sắp xếp</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Lượt mua</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->order }}</td>
                                            <td>
                                                <img src="{{ asset('/' . $product->image) }}" width="50px"
                                                    alt="{{ $product->title }}">
                                            </td>
                                            <td class="fw-bold text-truncate" style="max-width: 300px">
                                                {{ $product->title }}
                                            </td>
                                            <td class="fw-bolder">
                                                {{ number_format($product->price, 0, ',', '.') . '₫' }}
                                            </td>
                                            <td>{{ $product->updated_at->format('H:i d/m/Y') }}</td>
                                            <td>{{ $product->purchases }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status" type="checkbox" role="switch"
                                                        {{ $product->is_on_top ? 'checked' : '' }}
                                                        data-product-id="{{ $product->id }}" data-type="is_on_top"
                                                        title="Nổi bật">
                                                    <label class="form-check-label">Nổi bật</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status" type="checkbox" role="switch"
                                                        {{ $product->is_new ? 'checked' : '' }}
                                                        data-product-id="{{ $product->id }}" data-type="is_new"
                                                        title="Mới">
                                                    <label class="form-check-label">Mới</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-icon btn-clean me-0" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        {{-- CHỈNH SỬA: Truyền product->id thay vì cả object --}}
                                                        <button class="dropdown-item"
                                                            onclick="showDetailproduct({{ $product->id }})">Xem chi
                                                            tiết</button>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.product.edit', ['productId' => $product->id]) }}">Chỉnh
                                                            sửa</a>
                                                        <button class="dropdown-item text-danger"
                                                            onclick="deleteProduct({{ $product }})">Xóa</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Chi tiết sản phẩm --}}
    <div class="modal fade" id="detaiProduct" tabindex="-1" aria-labelledby="detaiProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable"> {{-- Tăng kích thước modal --}}
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title fs-5" id="detaiProductLabel"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Thêm spinner loading --}}
                    <div id="modal-loading" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    
                    {{-- Nội dung modal sẽ được load vào đây --}}
                    <div id="modal-content-wrapper" class="d-none">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <small class="text-dark fw-bold">Tên sản phẩm:</small>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="name" readonly />
                                </div>
                                <div class="form-group">
                                    <small class="text-dark fw-bold">Thẻ (Tag):</small>
                                    <input type="text" class="form-control form-control-sm rounded-0" id="tag" readonly />
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <small class="text-dark fw-bold">Giá:</small>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="price"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <small class="text-dark fw-bold">Đã bán:</small>
                                            <input type="text" class="form-control form-control-sm rounded-0" id="sold"
                                                readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <small class="text-dark fw-bold">Danh mục:</small>
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                id="category_name" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <small class="text-dark fw-bold">Kiểu dáng:</small>
                                            <input type="text" class="form-control form-control-sm rounded-0"
                                                id="style_name" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <small class="text-dark fw-bold">Mô tả ngắn:</small>
                                    <div id="description" class="p-2 border rounded"
                                        style="width: 100%; background-color: #f8f9fa; min-height: 100px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled id="is_on_top" />
                                    <label class="form-check-label text-dark fw-bold">Sản phẩm nổi bật</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled id="is_new" />
                                    <label class="form-check-label text-dark fw-bold">Sản phẩm mới</label>
                                </div>
                                <div class="form-group mt-3">
                                    <small class="text-dark fw-bold">Ảnh chính:</small>
                                    <div>
                                        <img id="image_modal" class="img-fluid rounded" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- THÊM MỚI: Khu vực hiển thị mô tả chi tiết và thư viện ảnh --}}
                        <hr>
                        <div id="product-details-container">
                            <h5 class="mb-3">Mô tả chi tiết</h5>
                            <div id="product-details-content">
                                {{-- Nội dung chi tiết sẽ được chèn vào đây --}}
                            </div>
                        </div>

                        <hr>
                        <div id="product-gallery-container">
                            <h5 class="mb-3">Thư viện ảnh</h5>
                            <div id="product-gallery" class="row">
                                {{-- Hình ảnh sẽ được chèn vào đây --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Đóng</button>
                    <a type="button" class="btn btn-primary" id="edit-product">Chỉnh sửa</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Xóa sản phẩm --}}
    <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="deleteProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="formDeleteProduct">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteProductLabel">Xác nhận xóa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="messageDelete"></p>
                        <p>Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa vĩnh viễn.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Hủy</button>
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
            Toast.fire({
                icon: "success",
                text: '{{ session('success') }}',
                timer: 3000,
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: "error",
                text: '{{ session('error') }}',
                timer: 3000,
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('.status').change(function() {
                var productId = $(this).data('product-id');
                var status = $(this).is(':checked')
                var type = $(this).data('type')
                $.ajax({
                    url: "{{ route('admin.product.change-status') }}",
                    method: 'POST',
                    data: {
                        id: productId,
                        status: status,
                        type: type,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.success) {
                            $(this).prop('checked', !status); // Revert checkbox on error
                            Toast.fire({
                                icon: "error",
                                text: 'Có lỗi khi thay đổi trạng thái',
                                timer: 3000,
                            });
                        } else {
                            Toast.fire({
                                icon: "success",
                                text: 'Cập nhật trạng thái thành công',
                                timer: 3000,
                            });
                        }
                    },
                    error: function() {
                        $(this).prop('checked', !status); // Revert checkbox on error
                        Toast.fire({
                            icon: "error",
                            text: 'Có lỗi khi thay đổi trạng thái',
                            timer: 3000,
                        });
                    }
                })
            })
        })
    </script>

    <script>
        function formatCurrencyVND(number) {
            if (isNaN(number)) return '';
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(number);
        }
        
        // CHỈNH SỬA: Hàm showDetailproduct được viết lại hoàn toàn
        function showDetailproduct(productId) {
            // Hiển thị modal và spinner
            $('#detaiProduct').modal('show');
            $('#modal-loading').removeClass('d-none');
            $('#modal-content-wrapper').addClass('d-none');

            // Tạo URL để gọi API
            const url = `/admin/san-pham/json/${productId}`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                         $('#modal-loading').html(`<p class="text-danger">${response.error}</p>`);
                         return;
                    }
                    const product = response.product;

                    // Điền thông tin cơ bản
                    $('#detaiProductLabel').text(product.title);
                    $('#name').val(product.title);
                    $('#tag').val(product.tag);
                    $('#price').val(formatCurrencyVND(product.price));
                    $('#sold').val(product.purchases);
                    $('#category_name').val(product.category ? product.category.name : 'N/A');
                    $('#style_name').val(product.style ? product.style.name : 'N/A');
                    $('#description').html(product.description);
                    $('#is_on_top').prop('checked', product.is_on_top == 1);
                    $('#is_new').prop('checked', product.is_new == 1);
                    $('#image_modal').attr('src', `/${product.image}`);
                    $('#edit-product').attr('href', `/admin/san-pham/sua-san-pham/${product.id}`);

                    // Xóa nội dung cũ và điền mô tả chi tiết
                    const detailsContent = $('#product-details-content');
                    detailsContent.empty();
                    if (product.details && product.details.length > 0) {
                        product.details.forEach(detail => {
                            const detailHtml = `
                                <div class="mb-3 p-2 border-bottom">
                                    <h6 class="fw-bold">${detail.title}</h6>
                                    <div>${detail.description}</div>
                                </div>
                            `;
                            detailsContent.append(detailHtml);
                        });
                    } else {
                        detailsContent.html('<p>Không có mô tả chi tiết.</p>');
                    }

                    // Xóa nội dung cũ và điền thư viện ảnh
                    const gallery = $('#product-gallery');
                    gallery.empty();
                    if (product.detail_images && product.detail_images.length > 0) {
                        product.detail_images.forEach(img => {
                             const imgHtml = `
                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                    <a href="/${img.image}" data-bs-toggle="tooltip" title="${img.alt_text || ''}">
                                        <img src="/${img.image}" class="img-fluid rounded border" alt="${img.alt_text || 'gallery image'}">
                                    </a>
                                </div>
                            `;
                            gallery.append(imgHtml);
                        });
                    } else {
                        gallery.html('<p>Không có hình ảnh trong thư viện.</p>');
                    }
                    
                    // Ẩn spinner và hiện nội dung
                    $('#modal-loading').addClass('d-none');
                    $('#modal-content-wrapper').removeClass('d-none');
                },
                error: function() {
                    $('#modal-loading').html('<p class="text-danger">Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</p>');
                }
            });
        }

        function deleteProduct(product) {
            document.getElementById('messageDelete').innerHTML =
                `Bạn có chắc chắn xóa sản phẩm <b>${product.title}</b> không?`;
            document.getElementById('formDeleteProduct').action = `/admin/san-pham/xoa-san-pham/${product.id}`;
            $('#deleteProduct').modal('show');
        }
    </script>
@endsection
