@extends('frontend.layouts.main')
@section('main-container')

    <div class="container pt-5">
    </div>
    <div class="main">
<h4>View Fuel</h4>
<hr>
<br>

        <label style="font-size: 18px;">Fuel Remaining: </label> {{$fuel->fuelLeft}} liters
        <br>
        <label style="font-size: 18px;">Fuel Price: </label> {{$fuel->pricePerLiter}} pkr

@endsection
