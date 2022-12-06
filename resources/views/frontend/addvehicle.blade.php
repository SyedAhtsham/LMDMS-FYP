@extends('frontend.layouts.main')
@section('main-container')

    <script>
        /* If browser back button was used, flush cache */
        // (function () {
        //     window.onpageshow = function(event) {
        //         if (event.persisted) {
        //             window.location.reload();
        //         }
        //     };
        // })();

    </script>


    <div class="container pt-5">


    </div>
    <div class="main">

        <h4>{{$title}}</h4>

        <hr>
        <br>
        <form action="{{$url}}" method="post">
            @csrf

            <div class="form-row pr-5">
                <div class="form-group col-md-4 pr-5">
                    <label for="inputPlateNo">Plate No. <span class="required">*</span></label>
                    <input type="text" name="plateNo" value="{{$vehicle->plateNo ?? old('plateNo')}}" class="form-control" id="inputPlateNo" placeholder="e.g., LEC-532"
                           value="{{old('plateNo')}}" required>
                    <span class="text-danger">
                    @error('plateNo')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group col-md-4 pr-5">
                    <label for="inputModel">Year <span class="required">*</span></label>
                    <input type="number" class="form-control" id="inputModel" name="model" min="1980" max="2099" step="1" value = "{{$vehicle->model ?? old('model')}}" placeholder="YYYY" required/>

                    <span class="text-danger">
                    @error('model')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group col-md-4 pr-5">

                        <label for="inputMake">Make <span class="required">*</span></label>
                        <select id="inputMake" name="make" class="form-control">


                            <option value="Toyota"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Toyota" ? "selected" : ""}}

                                @else
                                {{old('make') == "Toyota" ? "selected" : ""}}

                                @endif

                            >Toyota</option>
                            <option value="Kia"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Kia" ? "selected" : ""}}
                                @else
                                {{old('make') == "Kia" ? "selected" : ""}}
                                @endif
                            >Kia</option>
                            <option value="Suzuki"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Suzuki" ? "selected" : ""}}
                                @else
                                {{old('make') == "Suzuki" ? "selected" : ""}}
                                @endif
                            >Suzuki</option>

                            <option value="Honda"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Honda" ? "selected" : ""}}
                                @else
                                {{old('make') == "Honda" ? "selected" : ""}}
                                @endif
                            >Honda</option>

                            <option value="Foton"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Foton" ? "selected" : ""}}
                                @else
                                {{old('make') == "Foton" ? "selected" : ""}}
                                @endif
                            >Foton</option>
                            <option value="Hyundai"
                            @if(isset($vehicle->make))
                                {{$vehicle->make == "Hyundai" ? "selected" : ""}}
                                @else
                                {{old('make') == "Hyundai" ? "selected" : ""}}
                                @endif
                            >Hyundai</option>


                        </select>
                        <span class="text-danger">
                    @error('make')
                            {{$message}}
                            @enderror
                </span>
                    </div>




            </div>

            @php
                $vehType = $vehicle->getVehicleType->typeName ?? null;
                $cost = 0;
                $date = 0;
                if(isset($vehicle->getCompVehicle)){

                    $cost = $vehicle->getCompVehicle->price;
                    $date = $vehicle->getCompVehicle->purchasedDate;
                    }
                elseif(isset($vehicle->getContVehicle)){
                    $cost = $vehicle->getContVehicle->rentPerDay;
                    $date = $vehicle->getContVehicle->dateOfContract;
}


            @endphp

            <div class="form-row pr-5 pt-3">

                <div class="form-group col-md-4 pr-5">


                        <label for="inputVehicleType">Vehicle type <span class="required">*</span></label>
                        <select id="inputVehicleType" name="vehicleType" class="form-control">


                            <option value="1"
                            @if(isset($vehType))
                                {{$vehType == "Shahzore" ? "selected" : ""}}
                                @else
                                {{old('vehicleType') == "Shahzore" ? "selected" : ""}}
                                @endif
                            >Shahzore</option>

                            <option value="2"
                            @if(isset($vehType))

                                {{$vehType == "Suzuki" ? "selected" : ""}}
                                @else
                                {{old('vehicleType') == "Suzuki" ? "selected" : ""}}
                                @endif
                            >Suzuki</option>

                            <option value="3"
                            @if(isset($vehType))
                                {{$vehType == "Hilux" ? "selected" : ""}}
                                @else
                                {{old('vehicleType') == "Hilux" ? "selected" : ""}}
                                @endif
                            >Hilux</option>

                            <option value="4"
                            @if(isset($vehType))
                                {{$vehType == "Bike" ? "selected" : ""}}
                                @else
                                {{old('vehicleType') == "Bike" ? "selected" : ""}}

                                @endif

                            >Bike</option>
                        </select>
                        <span class="text-danger">
                    @error('canDrive')
                            {{$message}}
                            @enderror
                </span>
                    </div>




                    <div class="form-group col-md-4 pr-5">

                    <label for="inputStatus">Status <span class="required">*</span></label>
                    <select id="inputStatus" name="status" class="form-control">

                        <option value="Idle"
                        @if(isset($vehicle->status))
                            {{$vehicle->status == "Idle" ? "selected" : ""}}
                            @else
                            {{old('status') == "Idle" ? "selected" : ""}}
                            @endif
                        >Idle</option>
                        <option value="Active"
                        @if(isset($vehicle->status))
                            {{$vehicle->status == "Active" ? "selected" : ""}}

                            @else
                            {{old('status') == "Active" ? "selected" : ""}}

                            @endif

                        >Active</option>

                        <option value="In-Workshop"
                        @if(isset($vehicle->status))
                            {{$vehicle->status == "In-Workshop" ? "selected" : ""}}
                            @else
                            {{old('status') == "In-Workshop" ? "selected" : ""}}
                            @endif
                        >In-Workshop</option>



                    </select>
                    <span class="text-danger">
                    @error('status')
                        {{$message}}
                        @enderror
                </span>
                </div>


                <div class="form-group col-md-4 pr-5">

                    <label for="inputCondition">Condition <span class="required">*</span></label>
                    <div class="d-flex">
                        <input type="radio" name="condition" checked id="inputCondition" value="Good"

                        @if(isset($vehicle->condition))
                            {{$vehicle->condition == "Good" ? "checked" : ""}}

                            @else
                            {{old('condition') == "Good" ? "checked" : ""}}

                            @endif
                        >
                        <label style="padding-left: 5px; padding-right: 12px; padding-top: 10px; color: forestgreen;">Good</label>
                        <input type="radio" name="condition" id="inputCondition" value="Normal"
                        @if(isset($vehicle->condition))
                            {{$vehicle->condition == "Normal" ? "checked" : ""}}
                            @else
                            {{old('condition') == "Normal" ? "checked" : ""}}
                            @endif
                        > <label
                            style="padding-left: 5px; padding-right: 12px; padding-top: 10px; ">Normal</label>
                        <input type="radio" name="condition" id="inputCondition" value="Bad"
                        @if(isset($vehicle->condition))
                            {{$vehicle->condition == "Bad" ? "checked" : ""}}
                            @else
                            {{old('condition') == "Bad" ? "checked" : ""}}
                            @endif
                        > <label
                            style="padding-left: 5px; padding-right: 12px; padding-top: 10px; color: red;">Bad</label>
                    </div>
                    <span class="text-danger">
                    @error('condition')
                        {{$message}}
                        @enderror
                </span>
                </div>
            </div>


            <div class="form-row pr-5 pt-3">
                <div class="form-group col-4 pr-5">
                    <label for="inputOwnership">Ownership <span class="required">*</span></label>
                    <select id="inputOwnership" name="ownership" class="form-control"
                            required>
                        @php
                            $oship = old('ownership') ?? null;
                        @endphp

                        <option value="Company Owned"

                        @if(isset($oship))
                            {{$oship == "Company Owned" ? "selected" : ""}}
                            @elseif(isset($vehicle->getCompVehicle->vehicle_id))
                            selected
                            @endif
                        >Company Vehicle</option>
                        <option value="Contractual Vehicle"
                        @if(isset($oship))
                            {{$oship == "Contractual Vehicle" ? "selected" : ""}}
                            @elseif(isset($vehicle->getContVehicle->vehicle_id))
                            selected
                            @endif
                        >Contractual Vehicle</option>


                    </select>
                    <span class="text-danger">
                    @error('ownership')
                        {{$message}}
                        @enderror
                </span>
                </div>
            </div>

            <div class="form-row pr-5 pt-4">

                        <div class="form-group col-md-4 pr-5">
                            <label for="inputPrice">Rent/Cost in PKR <span class="required">*</span> &nbsp;&nbsp;&nbsp;<label style="font-size: 0.9em;"> (in case of Contractual Vehicle enter Rent)</label> </label>
                            <input type="text" name="price" value="{{$cost ?? old('price')}}" class="form-control" id="inputPrice" placeholder="e.g., 3500"
                                   value="{{old('price')}}" required>
                            <span class="text-danger">
                    @error('price')
                                {{$message}}
                                @enderror
                </span>
                        </div>
                        <div class="form-group col-md-4 pr-5">
                            <label for="inputDOP">Date of Purchase/Contract <span class="required">*</span> <label style="font-size: 0.9em;">(in case of Contractual Vehicle enter Contract Date)</label> </label>
                            <input type="date" name="dop" max="2022-09-28" class="form-control" id="inputDOP" value="{{$date ?? old('dop')}}"
                                   placeholder="">
                            <span class="text-danger">
                    @error('dop')
                                {{$message}}
                                @enderror
                </span>
                        </div>
                    </div>



                    <div class="form-row pt-5">

                        <div>
                            <a href="{{url('/frontend/view-vehicle')}}">
                                <button id="cancel" type="button" style="width: 8em; margin-right: 2em;" class="btn btn-danger">Cancel
                                </button>
                            </a>
                        </div>
                        <div>

                            <button type="submit" style="width: 8em; margin-right: 2em;  background-color: rgb(0, 74, 111);"
                                    class="btn btn-primary">Submit
                            </button>
                        </div>

                    </div>

        </form>
    </div>

@endsection



