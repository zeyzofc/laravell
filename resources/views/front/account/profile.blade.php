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
            @include('admin.message')
            <div class="card">
                <div class="card-header">
                    <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                </div>
                <div class="card-body p-4">
                            <div class="row">
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name">First Name</label>
                                <input readonly type="text" name="first_name" placeholder="First Name" id="first_name" class="form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input readonly type="text" name="last_name" placeholder="Last Name" id="last_name" class="form-control" placeholder="Last Name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input readonly type="text" name="email" id="email" placeholder="Your Email" class="form-control"value="{{ (!empty($customerAddress)) ? $customerAddress->email : ''}}">
                        </div>

                        <div class="mb-3">
                            <label for="mobile">Phone</label>
                            <input readonly type="text" name="mobile" id="mobile" placeholder="Phone Number" class="form-control" value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : ''}}">
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea readonly name="address" id="address" placeholder="Address" class="form-control" cols="30" rows="3">{{ (!empty($customerAddress)) ? $customerAddress->address : ''}}</textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                            <label for="apartment">Aparment, Suite, Unit, etc</label>
                                <input readonly type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : ''}}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="city">City</label>
                                <input readonly type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ (!empty($customerAddress)) ? $customerAddress->city : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="state">State</label>
                                <input readonly type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ (!empty($customerAddress)) ? $customerAddress->state : ''}}">
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="zip">ZIP</label>
                                <input readonly type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : ''}}">
                                <p></p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <a href="{{ route('account.edit', $customerAddress->id) }}" class="btn btn-dark">Edit Profile</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection