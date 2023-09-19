@extends('admin.layouts.app')

@section('content')				
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Edit Users</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form action="" method="post" id="userForm" name="userForm">
							@csrf
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label for="name">Name</label>
												<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$users->name}}">
												<p></p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label for="slug">Email</label>
												<input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{$users->email}}">
												<p></p>
											</div>
										</div>
                                        <div class="col-md-6">
											<div class="mb-3">
												<label for="slug">Phone</label>
												<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{$users->phone}}">
												<p></p>
											</div>
										</div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option {{ ($users->status ==1) ? 'selected' : '' }} value="1">Active</option>
                                                    <option {{ ($users->status ==0) ? 'selected' : '' }} value="0">Inactive</option>
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
							<div class="pb-5 pt-3">
								<button type="submit" class="btn btn-primary">Update</button>
								<a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
@endsection

@section('customJs')
<script>
    $('#userForm').submit(function(event){
        event.preventDefault();
        var element = $(this);
		$("button[type=submit]").prop('disabled',true);

        $.ajax({
            url: '{{ route("users.update",$users->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
				$("button[type=submit]").prop('disabled',false);

                if(response["status"] == true){

                    window.location.href="{{ route('users.index') }}";

                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

					$("#email").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                    $("#phone").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                }else{

					if(response['notFound'] == true) {
						window.location.href="{{ route('users.index') }}";
					}

                    var errors = response['errors']
                    if(errors['name']){
                        $("#name").addClass('is-invalid').
                        siblings('p').
                        addClass('invalid-feedback').html(errors['name']);
                    }else{
                        $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                
					if (errors['email']){
						$("#email").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['email']);
					}else{
						$("#email").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}

                    if (errors['phone']){
						$("#phone").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['phone']);
					}else{
						$("#phone").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}
				}

            }, error: function(jqXHR, exception){
                console.log("Ada Kesalahan!");
            }
        })
    });

	$('#name').change(function(){
		element = $(this);
		$("button[type=submit]").prop('disabled',true);
		$.ajax({
			url: '{{ route("getSlug") }}',
			type: 'get',
			data: {title: element.val()},
			dataType: 'json',
			success: function(response){
				$("button[type=submit]").prop('disabled',false);
					if(response["status"] == true) {
						$("#slug").val(response["slug"]);
					}
				}
			});
	});

</script>
@endsection