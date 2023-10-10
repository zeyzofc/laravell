@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">
            <form action="" method="get">
                <div class="card-tools ml-3 mt-2 mr-3">
                    <div class="input-group input-group" style="width: 100%;">
                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="card-title">
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="exportDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="exportDropdownButton">
                                <a href="{{ url('admin/orders/export/pdf') }}" class="dropdown-item"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
                                <a href="{{ url('admin/orders/export/csv') }}" class="dropdown-item"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                                <a href="{{ url('admin/orders/export/excel') }}" class="dropdown-item"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('orders.index') }}'" class="btn btn-info btn-sm"><i class="fas fa-sync-alt mr-1"></i>Refresh</button>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">
                <table id="example1" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">Order#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Amount</th>
                            <th>Date Purchased</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isNotEmpty())
                            @foreach ( $orders as $order )
                            <tr>
                                <td><a href="{{ route('orders.detail',[$order->id]) }}">{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->mobile }}</td>
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
                                        <span class="badge bg-danger">pending</span>
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
                                    {{\Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"> Records Not Found </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false, "searching": false,"paging": false,"info": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection