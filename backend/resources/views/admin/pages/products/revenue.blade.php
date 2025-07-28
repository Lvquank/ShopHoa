@extends('admin.index')

@section('content')
    {{--
        LƯU Ý QUAN TRỌNG:
        Controller của bạn (trong hàm revenue) cần truyền các biến sau vào view này:
        1. $products: Danh sách sản phẩm đã phân trang và tính toán doanh thu.
        2. $styles: Toàn bộ danh sách các kiểu dáng (Style::all()).
        3. $totalRevenue: Tổng doanh thu (tính trong controller).
        4. $totalPurchases: Tổng lượt mua (tính trong controller).
    --}}
    <div class="page-inner">
        <form action="{{ route('admin.product.revenue') }}" method="GET">
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
                                    <label class="text-dark fw-bold">Tên sản phẩm</label>
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
                                <button type="submit" class="btn btn-primary btn-sm">Lọc kết quả</button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </form>

        {{-- Thống kê tổng quan --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Tổng Doanh Thu</p>
                                    {{-- Controller cần truyền biến $totalRevenue --}}
                                    <h4 class="card-title">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}₫</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Tổng Lượt Mua</p>
                                    {{-- Controller cần truyền biến $totalPurchases --}}
                                    <h4 class="card-title">{{ number_format($totalPurchases ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title">Thống kê doanh thu theo sản phẩm</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Đã bán (lượt)</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ asset('/' . $product->image) }}" width="50px"
                                            alt="{{ $product->title }}">
                                    </td>
                                    <td class="fw-bold text-truncate" style="max-width: 300px" title="{{ $product->title }}">
                                        {{ $product->title }}
                                    </td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                    <td class="fw-bold">{{ $product->purchases }}</td>
                                    <td class="fw-bold text-success">
                                        {{-- Controller cần tính toán và truyền thuộc tính 'revenue' --}}
                                        {{ number_format($product->revenue, 0, ',', '.') . '₫' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Không tìm thấy sản phẩm nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
