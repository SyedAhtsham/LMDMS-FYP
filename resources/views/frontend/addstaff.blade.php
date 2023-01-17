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


        <h4>{{$title}}

            @if(isset($staff->staff_id))
            :

            <a style="font-size: 21px;" href="{{route('view.singlestaff', ['id'=>$staff->staff_id])}}">
                {{$staff->name}}
            </a>
@endif
        </h4>

        <hr>
        <br>
        <form action="{{$url}}" method="post">
            @csrf

            <div class="form-row pr-5">
                <div class="form-group col-md-4 pr-5">
                    <label for="inputName4">Name <span class="required">*</span></label>
                    <input type="text" name="name"  pattern="^([A-Za-z ]{4,30})$" title="e.g., Muhammad Ali" value="{{$staff->name ?? old('name')}}" class="form-control"
                           id="inputName4" placeholder="e.g., Muhammad Ali"
                           value="{{old('name')}}" required>
                    <span class="text-danger">
                    @error('name')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group col-md-4 pr-5">
                    <label for="input">Contact <span class="required">*</span></label>
                    <input type="text" max="14" pattern="^(03[0-9]{2}|04[0-9]{2}|05[0-9]{2}|09[0-9]{2})-[0-9]{7}$" name="contact" value="{{$staff->contact ?? old('contact')}}"
                           class="form-control" id="inputContact"
                           placeholder="e.g., 0315-52432142" title="e.g., 0315-52432142" value="{{old('contact')}}" required>
                    <span class="text-danger">
                    @error('contact')
                        {{$message}}
                        @enderror
                </span>
                </div>


            </div>

            <div class="form-row pr-5 mt-4">
            <div class="form-group col-md-4 pr-5">
                <label for="input">CNIC <span class="required">*</span></label>
                <input type="text" pattern="^[0-9+]{5}-[0-9+]{7}-[0-9]{1}$" max="14" name="cnic" value="{{$staff->cnic ?? old('cnic')}}" class="form-control"
                       id="inputCNIC"
                       placeholder="e.g., 61101-2323456-5" title="e.g., 61101-2323456-5" value="{{old('cnic')}}" required>
                <span class="text-danger">
                    @error('cnic')
                    {{$message}}
                    @enderror
                </span>
            </div>

                <div class="form-group col-md-4 pr-5">
                    <label for="inputEmail4">Email <span class="required">*</span></label>
                    <input type="email" name="email" value="{{$staff->email ?? old('email')}}" class="form-control"
                           id="inputEmail4"
                           placeholder="e.g., mbhuralqau@gmail.com" required>
                    <span class="text-danger">
                    @error('email')
                        {{$message}}
                        @enderror
                </span>
                    <label class="text-danger" style="display: none;">The email has already been taken.</label>
                </div>

            </div>


            <div class="form-row pr-5 mt-4">


                <div class="form-group col-md-4 pr-5">
                    <label for="inputDOB">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" id="inputDOB"
                           value="{{$staff->dob ?? old('dob')}}"
                           placeholder="">
                    <span class="text-danger">
                    @error('dob')
                        {{$message}}
                        @enderror
                </span>
                </div>
                <div class="form-group col-md-4 pr-5">

                    <label for="inputGender">Gender <span class="required">*</span></label>
                    <div class="d-flex">
                        <input type="radio" style="" name="gender" checked id="inputMale" value="Male"

                        @if(isset($staff->gender))
                            {{$staff->gender == "Male" ? "checked" : ""}}

                            @else
                            {{old('gender') == "Male" ? "checked" : ""}}

                            @endif
                        >
                        <label id="male" style="padding-left: 5px; padding-right: 12px; padding-top: 10px;">Male</label>
                        <input type="radio" name="gender" id="inputFemale" value="Female"
                        @if(isset($staff->gender))
                            {{$staff->gender == "Female" ? "checked" : ""}}
                            @else
                            {{old('gender') == "Female" ? "checked" : ""}}
                            @endif
                        > <label id="female"
                            style="padding-left: 5px; padding-right: 12px; padding-top: 10px;">Female</label>
                        <input type="radio" name="gender" id="inputOther" value="Other"
                        @if(isset($staff->gender))
                            {{$staff->gender == "Other" ? "checked" : ""}}
                            @else
                            {{old('gender') == "Other" ? "checked" : ""}}
                            @endif
                        > <label id="other"
                            style="padding-left: 5px; padding-right: 12px; padding-top: 10px;">Other</label>
                    </div>
                    <span class="text-danger">
                    @error('gender')
                        {{$message}}
                        @enderror
                </span>
                </div>
            </div>



            @if(isset($staff->staff_id) && Session::get('staff_id')==$staff->staff_id)
                <input type="hidden" name="position" value="{{$staff->position}}">
            @endif

            <div class="form-row pr-5 mt-4">
                <div class="form-group col-4 pr-5">
                    <label for="inputPosition">Position <span class="required">*</span></label>
                    <select id="inputPosition" onchange="showForDriver(this)"

                            @if(isset($staff->staff_id) && Session::get('staff_id')==$staff->staff_id)
                                disabled
                            @else
                                required
                                @endif
                            name="position" class="form-control"


                    >
                        @php
                            $pos = old('position') ?? null;
                        @endphp

                        <option value="Manager"

                        @if(isset($pos))
                            {{$pos == "Manager" ? "selected" : ""}}
                            @elseif(isset($staff->position))
                            {{$staff->position == "Manager" ? "selected" : ""}}
                            @endif
                        >Manager
                        </option>
                        <option value="Driver"
                        @if(isset($pos))
                            {{$pos == "Driver" ? "selected" : ""}}
                            @elseif(isset($staff->position))
                            {{$staff->position == "Driver" ? "selected" : ""}}
                            @endif
                        >Driver
                        </option>
                        <option value="Supervisor"
                        @if(isset($pos))
                            {{$pos == "Supervisor" ? "selected" : ""}}
                            @elseif(isset($staff->position))
                            {{$staff->position == "Supervisor" ? "selected" : ""}}
                            @endif
                        >Supervisor
                        </option>

                    </select>
                    <span class="text-danger">
                    @error('position')
                        {{$message}}
                        @enderror
                </span>
                </div>



                <div class="form-group col-8 pr-5">
                    <label for="inputAddress">Address <span class="required">*</span></label>
                    <input type="text" pattern="^([A-Za-z0-9#., ]{6,200})$" name="address" class="form-control" id="inputAddress"
                           value="{{$staff->address ?? old('address')}}"
                           placeholder="e.g., 84 Hostel 6 QAU" title="e.g., 84 Hostel 6 QAU" required>
                    <span class="text-danger">
                    @error('address')
                        {{$message}}
                        @enderror
                </span>
                </div>


            </div>

            @php
                $position = "";
                if(isset($staff->position)){
                $position = $staff->position;
                }

                 if(old('canDrive[]') !== null)
                    {
//                        echo "Shah";
                        $oldCanDrive[] = old('canDrive[]');
                    }

                 if(isset($staff->getDriver->canDrive)){
                     $canDriveArr = explode(', ', $staff->getDriver->canDrive);

                 }
            @endphp

            @if($position == "Driver" || old('position') == "Driver")
                <body onload="myFunction1()">
                <div id="ifYes1" class="form-row pr-5 pt-3">
                    <div class="form-group col-md-4 pr-5">
                        <label for="inputLicenseNo0">License No. <span class="required">*</span></label>
                        <input id="inputLicenseNo0" pattern="^[A-Z]{2}[0-9]{6}$" title="e.g., LE165487" type="text" name="licenseNo" class="form-control"
                               value="{{$staff->getDriver->licenseNo ?? old('licenseNo')}}"
                               placeholder="e.g., LE165487" >
                        <span class="text-danger">
                    @error('licenseNo')
                            {{$message}}
                            @enderror
                </span>
                    </div>
                    <div class="form-group col-md-4 pr-5">
                        <label for="inputYearsExperience0">Years Experience</label>

                        <input type="number" name="yearsExperience" min="0" max="40" class="form-control" id="inputYearsExperience0"
                               value="{{$staff->getDriver->yearsExp ?? old('yearsExperience')}}" placeholder="e.g., 1">
                    </div>
                    <div class="form-group col-4 pr-5">
                        <label for="inputCanDrive0">Can Drive <span class="required">*</span></label>
                        <select id="inputCanDrive0" name="canDrive[]"  multiple class="form-control selectpicker">

                            @foreach($vehicleTypes as $vT)
                                <option value={{$vT->typeName}}

                                @if(isset($staff->getDriver->canDrive))
                                    {{in_array($vT->typeName, $canDriveArr) ? "selected" : "" }}
                                    @else
                                    {{--                                            {{$oldCanDrive.contains($vT->vehicleType_id)  ? "selected" : ""}}--}}
                                        {{ (collect(old('canDrive'))->contains($vT->typeName)) ? 'selected':'' }}

                                    @endif

                                >{{$vT->typeName}}
                                </option>
                            @endforeach

                        </select>
                        <span class="text-danger">
                    @error('canDrive')
                            {{$message}}
                            @enderror
                </span>
                    </div>

                    <label id="canDriveError" style="visibility: hidden; color: red;">This field is required</label>

                </div>

                @else
                    <body onload="myFunction()">

                    @endif


                    <div id="ifYes" class="form-row pr-5 pt-3">
                        <div class="form-group col-md-4 pr-5">
                            <label for="inputLicenseNo">License No. <span class="required">*</span></label>
                            <input id="licenseNo1" type="text" pattern="^[A-Z]{2}[0-9]{6}$" title="e.g., LE165487" name="licenseNo" class="form-control"
                                   value="{{$staff->getDriver->licenseNo ?? old('licenseNo')}}"
                                   placeholder="e.g., LE165487" >
                            <span class="text-danger">
                    @error('licenseNo')
                                {{$message}}
                                @enderror
                </span>
                        </div>
                        <div class="form-group col-md-4 pr-5">
                            <label for="inputYearsExperience">Years Experience</label>
                            <input type="number" name="yearsExperience" min="0" max="40" class="form-control" id="inputYearsExperience1"
                                   value="{{$staff->getDriver->yearsExp ?? old('yearsExperience')}}"
                                   placeholder="e.g., 1">
                        </div>
                        <div class="form-group col-4 pr-5">
                            <label for="inputCanDrive1">Can Drive <span class="required">*</span></label>
                            <select id="inputCanDrive1" name="canDrive[]" multiple class="form-control selectpicker">

                                @foreach($vehicleTypes as $vT)
                                    <option value={{$vT->typeName}}

                                    @if(isset($staff->getDriver->canDrive))
                                        {{in_array($vT->typeName, $canDriveArr) ? "selected" : "" }}
                                        @else
                                        {{--                                            {{$oldCanDrive.contains($vT->vehicleType_id)  ? "selected" : ""}}--}}
                                            {{ (collect(old('canDrive'))->contains($vT->typeName)) ? 'selected':'' }}

                                        @endif

                                    >{{$vT->typeName}}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                    @error('canDrive')
                                {{$message}}
                                @enderror
                </span>
                        </div>

                    </div>


                    <div id="ifYes2" class="form-row pr-5 pt-3">
                        <div class="form-group col-md-4 pr-5">
                            <label for="licenseNo">License No. <span class="required">*</span></label>
                            <input id="licenseNo" type="text" name="licenseNo" pattern="^[A-Z]{2}[0-9]{6}$" title="e.g., LE165487" class="form-control"
                                   value="{{$staff->getDriver->licenseNo ?? old('licenseNo')}}"
                                   placeholder="e.g., LE165487" >
                            <span class="text-danger">
                    @error('licenseNo')
                                {{$message}}
                                @enderror
                </span>
                        </div>
                        <div class="form-group col-md-4 pr-5">
                            <label for="inputYearsExperience2">Years Experience</label>
                            <input type="number" name="yearsExperience" min="0" max="40" class="form-control" id="inputYearsExperience2"
                                   value="{{$staff->getDriver->yearsExp ?? old('yearsExperience')}}"
                                   placeholder="e.g., 1">
                        </div>


                        <div class="form-group col-4 pr-5">
                            <label for="inputCanDrive2">Can Drive <span class="required">*</span></label>
                            <select id="inputCanDrive2" name="canDrive[]" multiple class="form-control selectpicker"
                                    data-live-search="true">

                                @foreach($vehicleTypes as $vT)
                                    <option value={{$vT->typeName}}

                                    @if(isset($staff->getDriver->canDrive))
                                        {{in_array($vT->typeName, $canDriveArr) ? "selected" : "" }}
                                        @else
                                        {{--                                            {{$oldCanDrive.contains($vT->vehicleType_id)  ? "selected" : ""}}--}}
                                            {{ (collect(old('canDrive'))->contains($vT->typeName)) ? 'selected':'' }}

                                        @endif

                                    >{{$vT->typeName}}
                                    </option>
                                @endforeach


                            </select>
                            <span class="text-danger">
                    @error('position')
                                {{$message}}
                                @enderror
                </span>
                        </div>
                    </div>


                    <div class="form-row pt-5">

                        <div>
                            <a href="{{url('/frontend/view-staff')}}">
                                <button id="cancel" type="button" style="width: 8em; margin-right: 2em;"
                                        class="btn btn-danger">Cancel
                                </button>
                            </a>
                        </div>
                        <div>

                            <button id="submitBtn" type="submit"
                                    style="width: 8em; margin-right: 2em;  background-color: rgb(0, 74, 111);"
                                    class="btn btn-primary">Submit
                            </button>
                        </div>

                    </div>

        </form>
    </div>

@endsection

@section('scripts')

    <script>


        // document.getElementById('submitBtn').onclick = function()
        // {
        //     if(document.getElementById('inputPosition').value == "Driver") {
        //         if (document.getElementById('inputCanDrive1').value == null) {
        //             alert("Yes");
        //             document.getElementById('canDriveError').style.visibility = "visible";
        //         }
        //     }
        //
        // };



        document.getElementById('male').onclick = function(){
           document.getElementById('inputMale').checked = "true";
        };

        document.getElementById('female').onclick = function(){
            document.getElementById('inputFemale').checked = "true";
        };

        document.getElementById('other').onclick = function(){
            document.getElementById('inputOther').checked = "true";
        };




        //
        // $(document).ready(function () {
        //
        //     //editBtn002 is save button of driverField
        //     $(document).on('change', '#inputEmail4', function () {
        //
        //         let email = document.getElementById("inputEmail4").value;
        //
        //
        //             let str = email;
        //             $.ajax(
        //                 {
        //
        //                     type: "GET",
        //                     url: "/frontend/emailValidation/" + str,
        //
        //                     success: function (response) {
        //
        //
        //                     }
        //
        //                 });
        //
        //             // alert(vehicleID);
        //             // alert(driverID);
        //
        //
        //     });
        //
        // });




    </script>

    <script>
        document.getElementById('inputDOB').max = new Date().toISOString().split("T")[0];

    </script>


@endsection



