@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Password</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-12">
                @include('front.account.common.message')
            </div>
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                    </div>
                    <form action="" name="passwordForm" id="passwordForm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="mb-3">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control" placeholder="Current Password" id="currentPassword" name="currentPassword">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" placeholder="New Password" id="newPassword" name="newPassword">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" class="form-control" placeholder="Confirm New Password" id="confirmPassword" name="newPassword_confirmation">
                                <p></p>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-dark">Update</button>
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

@section('customJs')
<script>
    $("#passwordForm").submit(function(event){
    event.preventDefault();
    $.ajax({
        url: '{{ route("account.updatePassword") }}',
        type: 'post',
        data: $(this).serializeArray(),
        dataType: 'json',
        success: function(response){
            if (response.status == true) {
                // Reset the form and redirect on success
                $("#passwordForm")[0].reset();
                window.location.href = '{{ route("account.changePassword") }}';
            } else {
                var errors = response.errors;
                
                // Reset error messages for both fields initially
                $("#passwordForm #newPassword, #passwordForm #confirmPassword")
                    .removeClass('is-invalid')
                    .siblings('p')
                    .html('')
                    .removeClass('invalid-feedback');
                
                if (errors.currentPassword) {
                    $("#passwordForm #currentPassword")
                        .addClass('is-invalid')
                        .siblings('p')
                        .html(errors.currentPassword)
                        .addClass('invalid-feedback');
                } else {
                    $("#passwordForm #currentPassword")
                        .removeClass('is-invalid')
                        .siblings('p')
                        .html('')
                        .removeClass('invalid-feedback');
                }
                
                if (errors.newPassword) {
                    $("#passwordForm #newPassword, #passwordForm #confirmPassword")
                        .addClass('is-invalid')
                        .siblings('p')
                        .html(errors.newPassword)
                        .addClass('invalid-feedback');
                }
            }
        }
    });
});
</script>
@endsection