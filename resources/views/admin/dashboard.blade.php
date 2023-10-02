@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <!-- Add any additional content here if needed -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $data['categoryCount'] }}</h3>
                        <p>Total Category</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder"></i>
                    </div>
                    <a href="{{ route('categories.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $data['userCount'] }}</h3>
                        <p>Total Customer</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

			<div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $data['productCount'] }}</h3>
                        <p>Total Product</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a href="{{ route('products.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

			<div class="col-lg-4 col-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $data['orderCount'] }}</h3>
                        <p>Total Order</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

			<div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $data['orderUnpaidCount'] }}</h3>
                        <p>Unpaid Order Total</p>
                    </div>
                    <div class="icon">
                       <i class="fas fa-cart-arrow-down"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

			<div class="col-lg-4 col-6">
                <div class="small-box bg-pink">
                    <div class="inner">
                        <h3>{{ $data['orderPaidCount'] }}</h3>
                        <p>Total Order Complete</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('orders.index') }}" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Recap Report -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- Sales Recap Report Card -->
                <div class="card-header">
                    <h5 class="card-title">Sales Recap Report</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-wrench"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <a href="#" class="dropdown-item">Something else here</a>
                                <a class="dropdown-divider"></a>
                                <a href="#" class="dropdown-item">Separated link</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {!! $data['chart']->container() !!}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">Rp {{ number_format($data['currentMonthEarnings'], 2) }}</h5>
                                <span class="description-text">TOTAL EARNING FOR THIS MONTH</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block">
                                <h5 class="description-header">Rp {{ number_format($data['totalEarnings'], 2) }}</h5>
                                <span class="description-text">TOTAL EARNING</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Order -->
        <div class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title">Latest Orders</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Amount</th>
                            <th>Date Purchased</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['orders']->isNotEmpty())
                            @foreach ($data['orders'] as $order)
                                <tr>
                                    <td><a href="{{ route('orders.detail',[$order->id]) }}">{{ $order->id }}</a></td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>
                                        @if ($order->payment_status == '1')
                                            <span class="badge bg-danger">Unpaid</span>
                                        @elseif ($order->payment_status == '2')
                                            <span class="badge bg-success">Paid</span> 
                                        @elseif ($order->payment_status == '3')
                                            <span class="badge bg-warning">Expired</span>
                                        @else
                                            <span class="badge bg-black">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-danger">Pending</span>
                                        @elseif ($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif ($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @else
                                            <span class="badge bg-black">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($order->grand_total,2) }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-info float-right">View All Orders</a>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->


    <!-- Latest User & Product -->
    <div class="row">
        <div class="col-md-5">
            <!-- Latest User -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest User</h3>
                    <div class="card-tools">
                        <span class="badge badge-danger">{{ count($data['latestUser']) }} New User</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-10">
                    <ul class="users-list clearfix">
                        @if ($data['latestUser']->isNotEmpty())
                            @foreach ($data['latestUser'] as $user)
                                <li>
                                    <img src="{{ asset('front-assets/images/user.jpg') }}" alt="User Image" class="img-size-50">
                                    <a class="users-list-name" href="#">{{ $user->name }}</a>
                                    <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('users.index') }}">View All Users</a>
                </div>
            </div>
        </div>

        <!-- Recently Added Products -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recently Added Products</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @if ($data['latestProducts']->isNotEmpty())
                            @foreach ($data['latestProducts'] as $product)
                            @php
                                $productImage = $product->product_images->first();
                            @endphp
                        <li class="item">
                            <div class="product-img">
                                @if (!empty($productImage->image))
                                <img class="card-img-top"  src="{{ asset('uploads/product/small/'.$productImage->image) }}" alt="Product Image" class="img-size-50"/>
                                @else
                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="Product Image" class="img-size-50"/>
                                @endif
                            </div>
                            <div class="product-info">
                                <a href="{{ route("front.product",$product->slug) }}" class="product-title">{{ $product->title }}
                                </a>
                                <span class="badge badge-warning float-right">Rp {{ number_format($product->price,2) }}</span>
                                <span class="product-description">
                                    {{ $product->qty }} Left in Stock
                                </span>
                            </div>
                        </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('products.index') }}" class="uppercase">View All Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('customJs')
<script src="{{ $data['chart']->cdn() }}"></script>
{{ $data['chart']->script() }}
@endsection