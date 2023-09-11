@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <form action="" id="editProfileForm" name="editProfileForm" method="post">
                    @csrf
                    <div class="card-body p-4">
                                <div class="row">
                             <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" placeholder="First Name"
                                class="form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                class="form-control" placeholder="Last Name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Your Email"
                            class="form-control"value="{{ (!empty($customerAddress)) ? $customerAddress->email : ''}}">
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label for="mobile">Phone</label>
                            <input type="text" name="mobile" id="mobile" placeholder="Phone Number"
                            class="form-control" value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : ''}}">
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" placeholder="Address"
                            class="form-control" cols="30" rows="3">{{ (!empty($customerAddress)) ? $customerAddress->address : ''}}</textarea>
                            <p></p>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                            <label for="aparment">Aparment, Suite, Unit, etc</label>
                                <input type="text" name="apartment" id="apartment" class="form-control"
                                placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                placeholder="City" value="{{ (!empty($customerAddress)) ? $customerAddress->city : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="state">State</label>
                                <input type="text" name="state" id="state" class="form-control"
                                placeholder="State" value="{{ (!empty($customerAddress)) ? $customerAddress->state : ''}}">
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="zip">ZIP</label>
                                <input type="text" name="zip" id="zip" class="form-control"
                                placeholder="Zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('account.profile') }}" class="btn btn-danger" style="margin-left: 10px;">Cancel</a>
                        </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section("customJs")
<script>
    $('#editProfileForm').submit(function(event){
        event.preventDefault();
        var element = $(this);
		$("button[type=submit]").prop('disabled',true);

        $.ajax({
            url: '{{ route("account.update", $customerAddress->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
				$("button[type=submit]").prop('disabled',false);

                if(response["status"] == true){

					window.location.href="{{ route('account.profile') }}";

                    $("#first_name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

					$("#last_name").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");
                    
                    $("#email").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#mobile").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#address").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#city").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#state").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#zip").removeClass('is-invalid')
					.siblings('p')
                    .removeClass('invalid-feedback').html("");
                    

                }else{

					if(response ['notFound'] == true) {
						window.location.href = "{{ route('account.profile') }}";

					}

                    var errors = response['errors']
                    if(errors['first_name']){
                        $("#first_name").addClass('is-invalid').
                        siblings('p').
                        addClass('invalid-feedback').html(errors['first_name']);
                    }else{
                        $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                
					if (errors['last_name']){
						$("#last_name").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['last_name']);
					}else{
						$("#last_name").removeClass('is-invalid')
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

                    if (errors['mobile']){
						$("#mobile").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['mobile']);
					}else{
						$("#mobile").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}

                    if (errors['address']){
						$("#address").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['address']);
					}else{
						$("#address").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}

                    if (errors['city']){
						$("#city").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['city']);
					}else{
						$("#city").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}

                    if (errors['state']){
						$("#state").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['state']);
					}else{
						$("#state").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}

                    if (errors['zip']){
						$("#zip").addClass('is-invalid').
						siblings('p').
						addClass('invalid-feedback').html(errors['zip']);
					}else{
						$("#zip").removeClass('is-invalid')
						.siblings('p')
						.removeClass('invalid-feedback').html("");
					}
				}

            }, error: function(jqXHR, exception){
                console.log("Ada Kesalahan!");
            }
        })
    });
</script>
@endsection