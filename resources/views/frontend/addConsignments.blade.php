@extends('frontend.layouts.main')
@section('main-container')



    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('remove.consignment')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Remove Consignment</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="cons_id" id="cons_id"/>
                        <h5>Are you sure you want to remove this <b><i>Consignment</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
{{--                <form action="{{route('checkout.deliverySheet')}}" method="POST">--}}
{{--                    @csrf--}}
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" style="color: black;" id="exampleModalLabel">Add Consignments to Delivery Sheets</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="deliverySheet_id" id="deliverySheet_id"/>
                        <h5 style="color: black;">Are you sure you want to add the selected <b><i>Consignments</i></b> into delivery sheet?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" onclick="addConsignments()" class="btn btn-success">Yes</button>
                    </div>
{{--                </form>--}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="unCheckoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('checkout.deliverySheet')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Un-Check-out Delivery Sheet</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="deliverySheet_id" id="deliverySheet_idU"/>
                        <h5>Are you sure you want to Un-Check-out this <b><i>Delivery Sheet</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Un-Check-out</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="main pt-5" style="margin-right: 2em;">

        <input id="dsID" value="{{$deliverySheet->deliverySheet_id}}" hidden>
        <h4>Delivery Sheet: <label
                style="font-weight: bolder; font-size: 20px;"> {{$deliverySheet->deliverySheetCode}}</label></h4>



        <?php

        if ($deliverySheet->vhCode == "") {
            echo '<label><img src="/images/icons8-error.gif" width="35em"/><u> Since there was no idle vehicle, therefore need to hire contractual vehicles!</u></label>';

        }
        ?>
        <hr>


        <table>


            <tr>
                <td><b>Vehicle ID: </b></td>


                <td class="p-lg-2">
                    <div class="form-group mt-2 d-flex">

                        <div>
                            <select id="inputVehicle" name="vehicle" disabled class="form-control"
                                    required>


                                <?php
                                if (!isset($deliverySheet->vehicle_id)) {

                                    echo "<option value='' selected> None </option>";

                                }

                                foreach ($vehicles as $vehicle) {


                                    if (isset($deliverySheet->vehicle_id)) {

                                        if ($vehicle->vehicle_id === $deliverySheet->vehicle_id) {

                                            echo "<option value='$vehicle->vehicle_id' selected>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";
                                            $weightCap = $vehicle->weightCap;
                                            $volumeCap = $vehicle->volumeCap;

                                        } else {

                                            echo "<option value='$vehicle->vehicle_id'>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";
                                        }

                                    } else {
                                        echo "<option value='$vehicle->vehicle_id'>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";
                                    }

                                }

                                ?>


                            </select>

                        </div>

                    </div>

                </td>
                <td class="pl-5"></td>
                <td></td>

                <td><b>Driver: </b></td>

                <td class="p-lg-2">
                    <div class="form-group mt-2 d-flex">

                        <div>
                            <select id="inputDriver" name="driver" disabled class="form-control"
                                    required>


                                <?php
                                if (!isset($deliverySheet->driver_id)) {

                                    echo "<option value='' selected> None </option>";

                                }

                                foreach ($drivers as $driver) {


                                    if (isset($deliverySheet->driver_id)) {

                                        if ($driver->staff_id === $deliverySheet->driver_id) {

                                            echo "<option value='$driver->staff_id' selected>" . $driver->staffCode . " " . $driver->name . "</option>";

                                        } else {

                                            echo "<option value='$driver->staff_id'>" . $driver->staffCode . " " . $driver->name . "</option>";
                                        }

                                    } else {
                                        echo "<option value='$driver->staff_id'>" . $driver->staffCode . " " . $driver->name . "</option>";
                                    }

                                }

                                ?>


                            </select>

                        </div>

                    </div>
                </td>

                {{--                <td class="p-lg-3">{{$deliverySheet->drvName ?? "----"}}</td>--}}
                <td class="pl-5"></td>
                <td></td>

                <td><b>Total Weight: </b></td>
                <td class="p-lg-3" ><label id="weight" style="font-weight: bolder; font-size: x-large">{{$totalWeight}} </label> kg</td>


            </tr>

            <tr>
                <td><b>Date: </b></td>
                <td class="p-lg-3">{{$deliverySheet->created_at}}</td>
                <td class="pl-5"></td>
                <td></td>
                <td><b>Area: </b></td>
                <td class="p-lg-3">{{$deliverySheet->arNM}} ({{$deliverySheet->arCD}})</td>
                <td class="pl-5"></td>
                <td></td>

                <td><b>Total Volume: </b></td>
                <td class="p-lg-3" > <label id="volume" style="font-weight: bolder; font-size: x-large;">{{$totalVolume}}</label> m<sup>3</sup></td>

            </tr>
        </table>

        <br>

        <div class="row mt-2 mb-2 d-flex">
            <form action="" class="col-14 d-flex">
                <div class="form-group col-5">
                    <input type="search" name="search" id="" style="background-color: white;" class="form-control" value="{{$search}}"
                           placeholder="Search by consignment id, to-Address, ...">
                </div>
                <div class="">
                    <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                            class="btn btn-primary">Search
                    </button>
                </div>

                <div class="col-2">
                    <a href="{{url('/frontend/add-consignments/'.$deliverySheet->deliverySheet_id)}}">
                        <button type="button" style="width: 8em;"
                                class="btn btn-light">Reset
                        </button>
                    </a>
                </div>

                <div id="" class="col-2">
{{--                    <a href="{{url('/frontend/add-consignments/'.$deliverySheet->deliverySheet_id)}}">--}}
                        <button type="button" style=""
                                class="btn btn-success btnCheckout" id="addToDS" value=""><i class="fa fa-add"></i> Add to Delivery
                            Sheet
                        </button>

{{--                    </a>--}}
                </div>


            </form>


        </div>


        <table  class="table table-sm table-striped table-dark">
            <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
            <tr id="tableHeadings">

                <th>Sr #</th>
                <th>CN #</th>
                <th style="width: 400px;">To</th>
                <th>Contact</th>
                {{--            <th>Email</th>--}}
                <th>Weight</th>

                <th>Volume</th>
                <th>COD</th>
                {{--                    <th>Fuel</th>--}}
                {{--                    <th>Check-out time</th>--}}
                {{--            <th>CNIC</th>--}}

                <th style="width: 70px; text-align: center">
                    Action
{{--                    <div class="form-check">--}}
{{--                        <input class="form-check-input" title="Select All" style="height: 18px; width: 18px;"--}}
{{--                               type="checkbox" value="" id="selectAll">--}}
{{--                        --}}{{--Action--}}
{{--                    </div>--}}
                </th>
            </tr>
            </thead>

            <tbody>
            <tr>
                @php
                    $i = 1;
                    $size = sizeof($consignments);

                @endphp
                @if($size<=0)
            </tr>
        </table>

        <center><i> Sorry, no record found! </i></center>
        @else
            @foreach($consignments as $member)
                <tr id="{{$member->cons_id}}">
                    <td>
                        <div class="d-inline-flex">
                            <div>
                                @php
                                    $total = (($consignments->currentPage()-1) * 20) + $i;
                                    echo $total;

                                    $i++;
                                @endphp
                            </div>
                            @php
                                $createdAt = strtotime(\Carbon\Carbon::parse($member->created_at));
                                $currentDate = time();

                                $diff = ($currentDate-$createdAt)/3600;

                                if($diff <= 24){

                         echo '<div class="bg-warning rounded ml-1" style="width: 2.5em; text-align: center;">
                              New
                         </div>';
                             }
                            @endphp
                        </div>
                    </td>
                    <td>{{$member->consCode}}</td>
                    {{--                    <td>{{$member->arNM.", ".$member->arCT." (".$member->arCD.")"}}</td>--}}
                    {{--                    <td>{{$member->arNM." (".$member->arCD.")"}}</td>--}}
                    {{--            <td>{{$member->email}}</td>--}}
                    <td>{{$member->toAddress}}</td>


                    {{--                    @if(isset($member->spvName))--}}

                    {{--                        <td>{{$member->spvName}}</td>--}}

                    {{--                    @else--}}

                    {{--                        <td>---</td>--}}


                    {{--                    @endif--}}

                    <td>{{$member->toContact}}</td>
                    <td><label>{{$member->consWeight}}</label> <label>kg</label></td>

                    <td><label>{{$member->consVolume}}</label> <label> m<sup>3</sup></label></td>
                    <td>
                            <?php
                            if (isset($member->COD)) {
                                echo $member->COD;
                            } else {
                                echo "----";
                            }
                            ?>
                    </td>


                    {{--                    @if(isset($member->checkOutTime))--}}

                    {{--                        <td>{{$member->checkOutTime}}</td>--}}

                    {{--                    @else--}}

                    {{--                        <td>---</td>--}}


                    {{--                    @endif--}}


                    <td style="text-align: center">
                        <!-- Call to action buttons -->

                        {{--                    <ul class="list-inline m-0">--}}

                        {{--                    <li class="list-inline-item">--}}
                        {{--                       <a href="{{url('/frontend/edit-staff/{id}')}}">--}}
                        {{--                        <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
                        {{--                       </a>--}}
                        {{--                    </li>--}}
                        {{--                            @if((isset($search) && $search=="checked-out") || $member->status == "un-checked-out")--}}
                        {{--                            <li class="list-inline-item">--}}
                        {{--                                <a href="{{route('vehicle.assign', ['id'=>$member->deliverySheet_id])}}">--}}
                        {{--                                    <button class="btn btn-sm rounded-0 change-color0" type="button" data-toggle="tooltip" data-placement="top" title="View"><i class="fa-solid fa-eye"></i></button>--}}
                        {{--                                </a>--}}
                        {{--                            </li>--}}
                        {{--                            @else--}}
                        {{--                                <li class="list-inline-item">--}}

                        {{--                                    <button class="btn btn-sm rounded-0" type="button" data-toggle="tooltip" disabled data-placement="top" title="Assign"><i class="fa fa-add"></i></button>--}}

                        {{--                                </li>--}}
                        {{--                            @endif--}}

                        {{--                            <li class="list-inline-item">--}}
                        {{--                                <a href="{{route('vehicle.edit', ['id'=>$member->deliverySheet_id])}}">--}}
                        {{--                                    <button class="btn btn-sm rounded-0 change-color"  id="editBtn" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
                        {{--                                </a>--}}
                        {{--                            </li>--}}
                        {{--                    <li class="list-inline-item">--}}
                        {{--                        <a href="{{url('/frontend/delete-staff/'.$member->staff_id)}}">--}}
                        {{--                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                        {{--                        </a>--}}
                        {{--                    </li>--}}
                        {{--                        <li class="list-inline-item" style="justify-content: center;">--}}
                        <div class="form-check">
                            <input class="form-check-input selectSingle" style="height: 18px; width: 18px;"
                                   type="checkbox" value="{{$member->cons_id}}" id="cons{{$member->cons_id}}">

                        </div>

                        {{--                        </li>--}}
                        {{--                    </ul>--}}
                    </td>
                </tr>
                @endforeach

                @endif
                </tbody>

                </table>

                <div class="row pt-2">
                    {{$consignments->links()}}
                </div>


    </div>

@endsection


@section('scripts')

    <script>


        $(document).ready(function () {

            if (document.querySelectorAll('input[type=checkbox]:checked').length < 1) {
                document.getElementById('addToDS').disabled = "true";
            } else {
                document.getElementById('addToDS').disabled = "";
            }


            $(document).on('change', '#inputVehicle', function () {
                let vehicleID = $(this).val();


                $.ajax(
                    {

                        type: "GET",
                        url: "/frontend/vehicleAssignments/" + vehicleID,

                        success: function (response) {
                            let drivers = response.drivers;
                            // let flag = response.flag;


                            let driverSelect = document.getElementById('inputDriver');


                            // console.log(drivers);
                            while (driverSelect.children[0]) {
                                driverSelect.removeChild(driverSelect.lastChild);
                            }

                            // document.getElementById('assignBtn').disabled = '';

                            if (drivers.length === 0) {
                                let optionElement = document.createElement('option');
                                optionElement.innerHTML = '<label style="color:;">None</label>';
                                driverSelect.appendChild(optionElement);
                                // document.getElementById('assignBtn').disabled = 'true';

                            }


                            for (let i = 0; i < drivers.length; i++) {


                                let optionElement = document.createElement('option');
                                optionElement.innerHTML = drivers[i].staffCode + ", " + drivers[i].name;
                                // console.log(drivers[i]);
                                // console.log(drivers[i].staff_id);
                                optionElement.value = drivers[i].staff_id;
                                driverSelect.appendChild(optionElement);
                            }


                        }
                    }
                );

            });


        });

        let inputVehicle1 = document.getElementById("inputVehicle");
        let inputDriver1 = document.getElementById("inputDriver");
        let vehicleID1 = inputVehicle1.value;
        let driverID1 = inputDriver1.value;

        let size = <?php echo $size; ?>;

        if (vehicleID1 == "" || driverID1 == "" || size === 0) {
        } else {
        }

        let inputVehicle = document.getElementById("inputVehicle");
        let alreadySelected = inputVehicle.value;


        $(document).ready(function () {

            //editBtn002 is save button of vehicleField
            $(document).on('click', '#editBtn002', function () {

                let dsID = document.getElementById("dsID").value;

                let inputVehicle = document.getElementById("inputVehicle");

                let inputDriver = document.getElementById("inputDriver");
                let vehicleID = inputVehicle.value;
                if (vehicleID !== "" && alreadySelected !== vehicleID) {
                    alreadySelected = vehicleID;
                    let vehicleSelect = document.getElementById('inputVehicle');
                    // vehicleSelect[0].remove();
                    let driverID = inputDriver.value;

                    let str = vehicleID + "," + driverID + "," + dsID;
                    $.ajax(
                        {

                            type: "GET",
                            url: "/frontend/vehicleAssignment/" + str,

                            success: function (response) {

                                swal({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Delivery Sheet Vehicle Updated!',

                                    timer: 2000,
                                    buttons: false,
                                }).then(
                                    function () {
                                    },
                                    // handling the promise rejection
                                    function (dismiss) {
                                        if (dismiss === 'timer') {
                                            //console.log('I was closed by the timer')
                                        }
                                    }
                                )

                            }

                        });

                    // alert(vehicleID);
                    // alert(driverID);

                }
            });

        });


        let inputDriver = document.getElementById("inputDriver");
        let alreadySelectedDriver = inputDriver.value;

        $(document).ready(function () {

            //editBtn002 is save button of driverField
            $(document).on('click', '#saveBtnID', function () {

                let dsID = document.getElementById("dsID").value;

                let inputVehicle = document.getElementById("inputVehicle");
                let inputDriver = document.getElementById("inputDriver");
                let vehicleID = inputVehicle.value;
                let driverID = inputDriver.value;
                if (driverID != "" && alreadySelectedDriver !== driverID) {
                    alreadySelectedDriver = driverID;
                    let driverSelect = document.getElementById('inputDriver');
                    // driverSelect[0].remove();
                    let str = vehicleID + "," + driverID + "," + dsID;
                    $.ajax(
                        {

                            type: "GET",
                            url: "/frontend/vehicleAssignment/" + str,

                            success: function (response) {

                                swal({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Delivery Sheet Driver Updated!',

                                    timer: 2000,
                                    buttons: false,
                                }).then(
                                    function () {
                                    },
                                    // handling the promise rejection
                                    function (dismiss) {
                                        if (dismiss === 'timer') {
                                            //console.log('I was closed by the timer')
                                        }
                                    }
                                )


                            }

                        });

                    // alert(vehicleID);
                    // alert(driverID);
                }

            });

        });


        //Multi select javascript code

        let allCheckboxes = document.getElementsByClassName('selectSingle');

        console.log(allCheckboxes.length);


        const existingIDs = JSON.parse(sessionStorage.getItem("selectedCons")) || [];

        let selectedConsignments = [-1];
        sessionStorage.setItem('selectedCons', JSON.stringify(selectedConsignments));

        let consWeight =<?php echo $totalWeight; ?>;
        let consVolume = <?php echo $totalVolume; ?>;
        let weight = <?php echo $totalWeight; ?>;
        let volume = <?php echo $totalVolume; ?>;
        let weightCap = <?php echo $weightCap; ?>;
        let volumeCap = <?php echo $volumeCap; ?>;

        let vehicleType = <?php echo json_encode($vehicleType); ?>;


        let noOfCons = <?php echo $deliverySheet->noOfCons; ?>;
        let tempCons = noOfCons;


        let selectAll = document.getElementById('selectAll');

        for (let i = 0; i < allCheckboxes.length; i++) {
            allCheckboxes[i].addEventListener('change', function () {



                if (allCheckboxes[i].checked == true) {


                    weight += parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                    volume += parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);


                    if(vehicleType != "Bike") {
                        if (weight > weightCap - 360 || volume > volumeCap - 200) {
                            weight -= parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                            volume -= parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);

                            alert("Weight or Volume can not Exceed the Vehicle Capacity!");
                            allCheckboxes[i].checked = false;
                        }
                    }else{

                        tempCons++;
                        if(tempCons > 40){
                            weight -= parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                            volume -= parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);
tempCons--;
                            alert("Number of consignments can't exceed 40 for a Bike!");
                            allCheckboxes[i].checked = false;
                        }

                    }


                    if (document.querySelectorAll('input[type=checkbox]:checked').length < 1) {
                        document.getElementById('addToDS').disabled = "true";
                    } else {
                        document.getElementById('addToDS').disabled = "";
                    }

                    selectedConsignments.push(allCheckboxes[i].value);
                    // weight +=;
                document.getElementById('weight').innerHTML = weight;
                    document.getElementById('volume').innerHTML = volume;

// console.log(allCheckboxes[i].value);
                } else {


                    if (document.querySelectorAll('input[type=checkbox]:checked').length < 1) {
                        document.getElementById('addToDS').disabled = "true";
                    } else {
                        document.getElementById('addToDS').disabled = "";
                    }


                    weight -= parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                    volume -= parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);
                    // weight +=;
                    document.getElementById('weight').innerHTML = weight;
                    document.getElementById('volume').innerHTML = volume;

                    tempCons--;
                    const index = selectedConsignments.indexOf(allCheckboxes[i].value);
                    selectAll.checked = false;
                    sessionStorage.setItem('selectAllFlag', "false");
                    if (index != -1) {
                        selectedConsignments.splice(index, 1);
                    }



                }

                let checkedItems = document.querySelectorAll('input[type=checkbox]:checked');
                selectedConsignments = [];
                for (let i = 0; i < checkedItems.length; i++) {
                    selectedConsignments.push(checkedItems[i].value);
                    // console.log(checkedItems[i].value);
                }

                if (checkedItems.length == 20) {
                    selectAll.checked = true;
                    sessionStorage.setItem('selectAllFlag', "true");
                } else {
                    selectAll.checked = false;
                    sessionStorage.setItem('selectAllFlag', "false");
                }
                // console.log(selectedConsignments);
                for (let k = 0; k < selectedConsignments.length; k++) {
                    existingIDs.push(selectedConsignments[k]);
                }


                sessionStorage.setItem('selectedCons', JSON.stringify(existingIDs));
            });
        }


        allCheckboxes = document.getElementsByClassName('selectSingle');
        selectAll.addEventListener('click', function () {
            // alert("yess");

            if (selectAll.checked === true) {
                sessionStorage.setItem('selectAllFlag', "true");

weight = consWeight;
volume = consVolume;
                for (let i = 0; i < allCheckboxes.length; i++) {
                    allCheckboxes[i].checked = true;
                    weight += parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                    volume += parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);
                    // weight +=;

                    if(vehicleType != "Bike"){
                    if(weight > weightCap-360 || volume > volumeCap-200){
                        weight -= parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                        volume -= parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);


                        allCheckboxes[i].checked = false;
                        break;
                    }
                }else{
                    tempCons++;
                    if(tempCons > 40){
                        weight -= parseInt(document.getElementById(allCheckboxes[i].value).children[4].children[0].innerText);
                        volume -= parseInt(document.getElementById(allCheckboxes[i].value).children[5].children[0].innerText);
                        tempCons--;
                        // alert("Number of consignments can't exceed 40 for a Bike!");
                        allCheckboxes[i].checked = false;
                    }

                }

                    document.getElementById('weight').innerHTML = weight;
                    document.getElementById('volume').innerHTML = volume;

                }

                let checkedItems = document.querySelectorAll('input[type=checkbox]:checked');
                selectedConsignments = [];
                for (let i = 0; i < checkedItems.length; i++) {
                    selectedConsignments.push(checkedItems[i].value);

                }

            } else {
                sessionStorage.setItem('selectAllFlag', "false");
                //value is set to null back if the checkbox is unchecked
                for (let i = 0; i < allCheckboxes.length; i++) {
                    allCheckboxes[i].checked = false;
                   // weight +=;

                }

                weight = consWeight;
                volume = consVolume;
                document.getElementById('weight').innerHTML = weight;
                document.getElementById('volume').innerHTML = volume;
tempCons = noOfCons;

                let checkedItems = document.querySelectorAll('input[type=checkbox]:checked');
                selectedConsignments = [];
                for (let i = 0; i < checkedItems.length; i++) {
                    selectedConsignments.push(checkedItems[i].value);

                }
                console.log(selectedConsignments);
            }


            for (let k = 0; k < selectedConsignments.length; k++) {
                existingIDs.push(selectedConsignments[k]);
            }


            if (document.querySelectorAll('input[type=checkbox]:checked').length < 1) {
                document.getElementById('addToDS').disabled = "true";
            } else {
                document.getElementById('addToDS').disabled = "";
            }


            sessionStorage.setItem('selectedCons', JSON.stringify(existingIDs));

            // console.log(selectedConsignments);
        });


        $(document).ready(function () {

            const mySelections = JSON.parse(sessionStorage.getItem('selectedCons'));

            if (typeof (mySelections) != "undefined") {
                if (sessionStorage.getItem('selectAllFlag') === "true") {

                    selectAll.checked = true;
                }

                for (let i = 2; i < mySelections.length; i++) {
                    // console.log(mySelections[i]);
                    // console.log(mySelections[i]);
                    if (document.getElementById("cons" + mySelections[i]) != null) {
                        document.getElementById("cons" + mySelections[i]).checked = true;
                    }
                }

            }

        });



        function addConsignments(){

            //This needs to be changed to the sessionstprage consignments to work for the consignments that are selected before search
            let temp = document.querySelectorAll('input[type=checkbox]:checked');

            let consignments = [];
            let dsID = <?php echo $deliverySheet->deliverySheet_id; ?>;
consignments.push(dsID.toString());
            for(let i=0; i<temp.length; i++){
                consignments.push(temp[i].value);
            }

            const str = JSON.stringify(consignments);

            $.ajax(
                {

                    type: "GET",
                    url: "/frontend/add-consignments-toDS/" + str,

                    success: function (response) {

                        swal({
                            title: 'Success!',
                            icon: 'success',
                            text: 'Consignments Added to the Delivery Sheet!',

                            timer: 2000,
                            buttons: false,
                        }).then(
                            function () {
                                location.reload();
                            },
                            // handling the promise rejection
                            function (dismiss) {
                                if (dismiss === 'timer') {

                                    //console.log('I was closed by the timer')
                                }
                            }
                        )


                    }

                });

        }


    </script>




    <script>
        $(document).ready(function () {
            $('.btnCheckout').click(function (e) {
                e.preventDefault();
                let deliverySheet_id = $(this).val();
                $('#deliverySheet_id').val(deliverySheet_id);
                $('#checkoutModal').modal('show');

            });

        });
    </script>

    <script>
        $(document).ready(function () {
            $('.btnUnCheckout').click(function (e) {
                e.preventDefault();
                let deliverySheet_id = $(this).val();
                $('#deliverySheet_idU').val(deliverySheet_id);
                $('#unCheckoutModal').modal('show');

            });

        });
    </script>



    <script>
        $(document).ready(function () {
            $('.deleteConsignmentBtn').click(function (e) {
                e.preventDefault();
                let cons_id = $(this).val();
                $('#cons_id').val(cons_id);
                $('#deleteModal').modal('show');

            });

        });
    </script>

@endsection





