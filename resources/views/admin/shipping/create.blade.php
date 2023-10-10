@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Management</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group mt-2">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="importDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Import
                    </button>
                    <div class="dropdown-menu" aria-labelledby="importDropdownButton">
                        <a href="{{ url('admin/shipping/import/csv') }}" class="dropdown-item"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#importModal"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                    </div>
                </div>
                <div class="btn-group mt-2">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="exportDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Export
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exportDropdownButton">
                        <a href="{{ url('admin/shipping/export/pdf') }}" class="dropdown-item"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
                        <a href="{{ url('admin/shipping/export/csv') }}" class="dropdown-item"><i class="fas fa-file-csv mr-1"></i>CSV</a>
                        <a href="{{ url('admin/shipping/export/excel') }}" class="dropdown-item"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                    </div>
                </div>
                <button type="button" onclick="window.location.href='{{ route('shipping.create') }}'" class="btn btn-info btn-sm mt-2"><i class="fas fa-sync-alt mr-1"></i>Refresh</button>
            </div>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Excel File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('shipping.import_excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="file">Choose Excel File:</label>
                                    <input type="file" name="file" class="form-control" accept=".xlsx">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
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
        <form action="" method="post" id="shippingForm" name="shippingForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select a Country</option>
                                    @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option value="rest_of_world">Rest of the World</option>
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i>Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @if ($shippingCharges->isNotEmpty())
                            @foreach ($shippingCharges as $shippingCharge)
                            <tr>
                                <td>{{ $shippingCharge->id }}</td>
                                <td>
                                    {{ ($shippingCharge->country_id == 'rest_of_world') ? 'Rest of the World' : $shippingCharge->name }}
                                </td>
                                <td>Rp {{ number_format($shippingCharge->amount) }}</td>
                                <td>
                                    <a href="{{ route('shipping.edit', $shippingCharge->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteRecord({{ $shippingCharge->id }});" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $('#shippingForm').submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled',true);

        $.ajax({
            url: '{{ route("shipping.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled',false);

                if(response["status"] == true){
                    window.location.href="{{ route('shipping.create') }}";
                }else{
                    var errors = response['errors']
                    if(errors['country']){
                        $("#country").addClass('is-invalid').
                        siblings('p').
                        addClass('invalid-feedback').html(errors['country']);
                    }else{
                        $("#country").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }

                    if (errors['amount']){
                        $("#amount").addClass('is-invalid').
                        siblings('p').
                        addClass('invalid-feedback').html(errors['amount']);
                    }else{
                        $("#amount").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                }

            }, error: function(jqXHR, exception){
                console.log("Ada Kesalahan!");
            }
        })
    });

    function deleteRecord(id) {
        var url = '{{ route("shipping.delete", "ID") }}';
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
                                'Shipping charge has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.href = "{{ route('shipping.create') }}";
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the shipping charge.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
</script>
@endsection
