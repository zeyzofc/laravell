@extends('front.layouts.app')

@section('content')
 <section class="container">
    <div class="col-md-12 text-center py-5">


        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
       
        <h1>Thank You!</h1>
        <p>Your Order ID is : {{$id}} </p>
        <p>Please Complete Your Payment!</p>
        <button id="viewOrderButton" class="btn btn-warning text-white border border-dark">
           View Order Details
           <i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 6px;"></i>
        </button>
    </div>
 </section>
@endsection

@section('customJs')
<script>
    // JavaScript to handle the button click and redirect
    document.getElementById('viewOrderButton').addEventListener('click', function() {
        window.location.href = "{{ route('account.orderDetail', $data['order']->id) }}";
    });
</script>
@endsection