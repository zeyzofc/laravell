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
    <!-- /.card -->
        <div class="container">
            <canvas id="myChart"></canvas>
        </div>
</section>
<!-- /.content -->
@endsection


@section('customJs')
<script>
    // Sample data (replace with your data)
    const data = {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Monthly Sales',
            data: [1000, 1200, 900, 1500, 2000],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    // Configuration options for the chart
    const options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Get the canvas element and render the chart
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>
@endsection