@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Discount Coupons</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('coupons.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i>New Coupons</a>
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
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="importDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Import
                            </button>
                            <div class="dropdown-menu" aria-labelledby="importDropdownButton">
                                <a href="{{ url('admin/coupons/import/pdf') }}" class="dropdown-item"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
                                <a href="{{ url('admin/coupons/import/csv') }}" class="dropdown-item"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                                <a href="{{ url('admin/coupons/import/excel') }}" class="dropdown-item"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="exportDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="exportDropdownButton">
                                <a href="{{ url('admin/coupons/export/pdf') }}" class="dropdown-item"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
                                <a href="{{ url('admin/coupons/export/csv') }}" class="dropdown-item"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                                <a href="{{ url('admin/coupons/export/excel') }}" class="dropdown-item"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                            </div>
                        </div>
                        <button type="button" onclick="window.location.href='{{ route('coupons.index') }}'" class="btn btn-info btn-sm"><i class="fas fa-sync-alt mr-1"></i>Refresh</button>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">
                <table id="example1" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>Expires Date</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($discountCoupons->isNotEmpty())
                            @foreach ( $discountCoupons as $discountCoupon )
                            <tr>
                                <td>{{ $discountCoupon->id }}</td>
                                <td>{{ $discountCoupon->code }}</td>
                                <td>{{ $discountCoupon->name }}</td>
                                <td>
                                    @if ($discountCoupon->type == 'percent')
                                        {{ $discountCoupon->discount_amount }}%
                                    @else
                                        Rp {{ $discountCoupon->discount_amount }}
                                    @endif
                                </td>
                                <td>{{ (!empty($discountCoupon->starts_at)) ? \Carbon\Carbon::parse($discountCoupon->starts_at)->format('Y/m/d H:i') : ''}}</td>
                                <td>{{ (!empty($discountCoupon->expires_at)) ? \Carbon\Carbon::parse($discountCoupon->expires_at)->format('Y/m/d H:i') : ''}}</td>
                                <td>
                                    @if ($discountCoupon->status == 1)
                                        <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('coupons.edit', $discountCoupon->id)}}">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" onclick="deleteCoupon({{$discountCoupon->id}})" class="text-danger w-4 h-4 mr-1">
                                        <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
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
                {{ $discountCoupons->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    function deleteCoupon(id) {
        var url = '{{ route("coupons.delete", "ID") }}';
        var newUrl = url.replace("ID", id);

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === true) {
                            Swal.fire(
                                'Deleted!',
                                'Discount coupon has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.href = "{{ route('coupons.index') }}";
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the discount coupon.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
</script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "searching":false,
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