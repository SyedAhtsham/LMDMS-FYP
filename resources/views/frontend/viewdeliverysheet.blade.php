@extends('frontend.layouts.main')
@section('title', $deliverySheet->deliverySheetCode . ' | ')
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
                        <input type="hidden" name="cons_id" id="cons_id" />
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
                <form action="{{route('checkout.deliverySheet')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Check-out Delivery Sheet</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="deliverySheet_id" id="deliverySheet_id" />
                        <h5>This action is Undo-able! <br>
                            Are you sure you want to Check-out this <b><i>Delivery Sheet</i></b>?</h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Yes Check-out</button>
                    </div>
                </form>
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
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Mark Delivered</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="deliverySheet_id" id="deliverySheet_idU" />
                        <h5>Are you sure you want to Finish this <b><i>Delivery Sheet</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Mark Delivered</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="main pt-5" style="margin-right: 2em;" >

<input id="dsID" value="{{$deliverySheet->deliverySheet_id}}" hidden>
        <h4>Delivery Sheet: <label style="font-weight: bolder; font-size: 20px;"> {{$deliverySheet->deliverySheetCode}}</label> <label class="text-success" style="font-weight: ; font-size: 18px;"> {{($deliverySheet->finished == 1) ? "Marked Delivered" :"" }}</label></h4>
        <?php

        if($idleVehicles == 0){
        echo '<label><img src="/images/icons8-error.gif" width="35em"/><u> Since there is no idle vehicle for this Delivery Sheet, therefore need to hire contractual vehicles!</u></label>';

        }
        ?>
        <hr>




        <table>



            <tr>
                <td ><b>Vehicle: </b></td>



                <td class="pl-lg-2"><div class="form-group d-flex">

                        <?php
                        if((\Illuminate\Support\Facades\Session::get('position') == "Driver" || \Illuminate\Support\Facades\Session::get('position') == "Manager" || \Illuminate\Support\Facades\Session::get('position') == "Supervisor") && ($deliverySheet->status == "checked-out") && ($deliverySheet->vehicle_id != null) ){

                            ?>
                        <div class="form-group d-flex" style="margin-top: 30px;">

                        <a href="{{route('view.singlevehicle', ['id'=>$deliverySheet->vehicle_id])}}">
                            {{$vehicleCode ?? ""}}
                        </a>

                            <?php

                        }else {
                            ?>

                        <div>
                        <select id="inputVehicle"  name="vehicle" disabled  class="form-control"
                                 required>



<?php
                                if (!isset($deliverySheet->vehicle_id)) {

                                    echo "<option value='-1' selected> None </option>";

                                } else {
                                    echo "<option value='-1' > None </option>";
                                }

                                foreach ($vehicles as $vehicle) {


                                    if (isset($deliverySheet->vehicle_id)) {

                                        if ($vehicle->vehicle_id === $deliverySheet->vehicle_id) {

                                            echo "<option value='$vehicle->vehicle_id' selected>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";

                                        } else {

                                            echo "<option value='$vehicle->vehicle_id'>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";
                                        }

                                    } else {
                                        echo "<option value='$vehicle->vehicle_id'>" . $vehicle->vehicleCode . ", " . $vehicle->make . " " . $vehicle->typeName . " (" . $vehicle->weightCap . "kg, " . $vehicle->volumeCap . "m3)</option>";
                                    }

                                }
                            }

                            ?>


                        </select>

                        </div>
                       &nbsp; <div class="mt-1" id="editBtn001Div">

                            @if($deliverySheet->status != "checked-out")
                            <button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit()" id="editBtn001" type="button"
                                    data-toggle="" data-placement="top" title="Edit"><i
                                    class="fa fa-edit"></i></button>
@endif

                        </div>
                    </div>

    </td>
                <td class="pl-5">  </td>
                <td> </td>

                <td ><b>Driver: </b></td>

                <td class="p-lg-2"><div class="form-group  d-flex">

                        <?php
                        if((\Illuminate\Support\Facades\Session::get('position') == "Driver" || \Illuminate\Support\Facades\Session::get('position') == "Manager" || \Illuminate\Support\Facades\Session::get('position') == "Supervisor") && ($deliverySheet->status == "checked-out") && ($deliverySheet->driver_id != null) ){

                            ?>
                        <div class="form-group d-flex" style="margin-top: 30px;">

                            <a href="{{route('view.singlestaff', ['id'=>$deliverySheet->driver_id])}}">
                                {{$driverCode ?? ""}}
                            </a>

                                <?php

                            }else {
                                ?>


                            <div>
                        <select id="inputDriver"  name="driver" disabled class="form-control"
                                required>



                            <?php
                            if(!isset($deliverySheet->driver_id)){

                                echo "<option value='-1' selected> None </option>";

                            }else{
                                echo "<option value='-1' > None </option>";
                            }

                            foreach ($drivers as $driver){


                                if(isset($deliverySheet->driver_id)){

                                    if($driver->staff_id === $deliverySheet->driver_id){

                                        echo "<option value='$driver->staff_id' selected>".$driver->staffCode." ".$driver->name."</option>";

                                    }else{

                                        echo "<option value='$driver->staff_id'>".$driver->staffCode." ".$driver->name."</option>";
                                    }

                                }
                                else{
                                    echo "<option value='$driver->staff_id'>".$driver->staffCode." ".$driver->name."</option>";
                                }

                            }
                            }
                            ?>


                        </select>

                    </div>
                    &nbsp; <div class="mt-1" id="btnDiv">
                            @if($deliverySheet->status != "checked-out")
                        <button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit1()" id="editBtnID" type="button"
                                data-toggle="" data-placement="top" title="Edit"><i
                                class="fa fa-edit"></i></button>


@endif

                    </div>
                    </div>
                </td>

{{--                <td class="p-lg-3">{{$deliverySheet->drvName ?? "----"}}</td>--}}
                <td class="pl-5">  </td>
                <td> </td>

                <td ><b>Total Weight: </b></td>
                <td class="p-lg-3">{{$totalWeight}} kg</td>


            </tr>
            <tr>
                <td><b>Date: </b></td>
                <td class="p-lg-3">{{$deliverySheet->created_at}}</td>
                <td class="pl-5"> </td>
                <td> </td>
                <td><b>Area: </b></td>
                <td  class="p-lg-3">{{$deliverySheet->arNM}} ({{$deliverySheet->arCD}})</td>
                <td class="pl-5">  </td>
                <td> </td>

                <td ><b>Total Volume: </b></td>
                <td class="p-lg-3">{{$totalVolume}} m<sup>3</sup></td>

            </tr>
        </table>

        <br>

        <div class="row mt-2 mb-2 d-flex">
            <form action="" class="col-14 d-flex">
                <div class="form-group col-5">
                    <input type="search" name="search" id="" class="form-control" value="{{$search}}" placeholder="Search by consignment id, to-Address, ...">
                </div>
                <div class="">
                    <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                            class="btn btn-primary">Search
                    </button>
                </div>

                <div class="col-2">
                    <a href="{{url('/frontend/view-deliverysheet/'.$deliverySheet->deliverySheet_id)}}">
                        <button type="button" style="width: 8em;"
                                class="btn btn-light">Reset
                        </button>
                    </a>
                </div>


                @if(Session::get('position') != "Driver")
                <div id="addConsignmentLong" class="col-2">
{{--                    <a href="{{url('/frontend/add-consignments/'.$deliverySheet->deliverySheet_id)}}">--}}
                <button type="button" style=""
                        class="btn btn-secondary" onclick="addConsURL()" id="addConsLongBtn" value=""> <i class="fa fa-add"></i> Add Consignments
                </button>

{{--                    </a>--}}
                </div>

                <div id="addConsignmentShort" class="col-2" style="">
{{--                    <a href="{{url('/frontend/add-consignments/'.$deliverySheet->deliverySheet_id)}}">--}}
                        <button type="button" style="" title="Add Consignments"
                                class="btn btn-secondary" onclick="addConsURL()" id="addConsShortBtn" value=""> <i class="fa fa-add"></i>
                        </button>
{{--                    </a>--}}
                </div>


                <div class="col-2 ">
                    <form action="">


                            @if($deliverySheet->status == 'un-checked-out')

                        <button id="checkoutLong" type="submit" style=""
                                class="btn btn-success btnCheckout" id="checkoutBtn" value={{$deliverySheet->deliverySheet_id}}> <i class="fa fa-check"></i> Check-out
                        </button>

                        <button id="checkoutShort" type="submit" style=""
                                class="btn btn-success btnCheckout" id="checkoutBtn" title="Checkout" value={{$deliverySheet->deliverySheet_id}}> <i class="fa fa-check"></i>
                        </button>



                   @else

                        <button id="checkedOutShort" type="" class="btn btn-success" disabled> <i class="fa fa-check-double"></i>
                        </button>
                       <button id="checkedOutLong" type="" style=""
                                class="btn btn-success" disabled  ><i class="fa fa-check-double"></i> Checked-out
                        </button>


                      @endif


                    </form>

                </div>
                @else

                    @if($deliverySheet->finished == 0)
                    <div class="col-2">
                    <button id="checkoutLong" type="submit" style=""
                            class="btn btn-success btnUnCheckout float-right" id="checkoutBtn" value={{$deliverySheet->deliverySheet_id}}> <i class="fa fa-flag-checkered"></i>  Mark Deliver
                    </button>

                    <button id="checkoutShort" type="submit" style=""
                            class="btn btn-success btnUnCheckout float-right" id="checkoutBtn" title="Finish" value={{$deliverySheet->deliverySheet_id}}> <i class="fa-solid fa-flag-checkered"></i>
                    </button>

                    </div>
                    @else
                        <div class="col-2">
                            <button id="checkoutLong" type="submit" style=""
                                    class="btn btn-success btnUnCheckout float-right" disabled id="checkoutBtn" value={{$deliverySheet->deliverySheet_id}}> <i class="fa fa-flag-checkered"></i>  Marked Delivered
                            </button>

                            <button id="checkoutShort" type="submit" style=""
                                    class="btn btn-success btnUnCheckout float-right" disabled id="checkoutBtn" title="Finish" value={{$deliverySheet->deliverySheet_id}}> <i class="fa-solid fa-flag-checkered"></i>
                            </button>

                        </div>

                @endif
                    @endif


            </form>


        </div>




            <table  class="table table-sm table-striped" >
                <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
                <tr>

                    <th style="width: 60px;">Sr #</th>
                    <th>CN #</th>
                    <th >To</th>
                    <th>Contact</th>
                    {{--            <th>Email</th>--}}
                    <th>Weight</th>

                    <th>Volume</th>
                    <th>COD</th>
{{--                    <th>Fuel</th>--}}
{{--                    <th>Check-out time</th>--}}
                    {{--            <th>CNIC</th>--}}

                    <th>Action</th>
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

                     echo '<div class="bg-warning rounded ml-1 newMessage" style="width: 2.5em; text-align: center;">
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
                    <td>{{$member->consWeight}}</td>

                    <td>{{$member->consVolume}}<sup>3</sup></td>
                <td>{{$member->COD}}</td>


{{--                    @if(isset($member->checkOutTime))--}}

{{--                        <td>{{$member->checkOutTime}}</td>--}}

{{--                    @else--}}

{{--                        <td>---</td>--}}


{{--                    @endif--}}


                    <td>
                        <!-- Call to action buttons -->

                        <ul class="list-inline m-0">

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
                            <li class="list-inline-item">
                                {{--                            <a href="{{route('vehicle.delete', ['id'=>$member->vehicle_id])}}">--}}
                                {{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                                <?php if($deliverySheet->status == 'un-checked-out') {
                                    echo '<button class="btn btn-sm rounded-2 deleteConsignmentBtn change-color1" type="button" data-toggle="tooltip" data-placement="top" title="Remove" value='.$member->cons_id.'><i class="fa fa-trash"></i></button>';
                                }
                                else{
                                    echo '<button class="btn btn-sm" style="border: none;" type="button" disabled data-toggle="tooltip" data-placement="top" title="Remove" value='.$member->cons_id.'><i class="fa fa-trash"></i></button>';
                                }

                                ?>

                                {{--                            </a>--}}
                            </li>
                        </ul>
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



        // if(document.getElementById('inputVehicle').value == ""){
        //     addConsDiv = document.getElementById('addConsignmentLong');
        //
        //
        //
        //     addConsDiv.innerHTML = '<button type="button" style="" class="btn btn-secondary" id="addConsLongBtn" disabled value=""> <i class="fa fa-add"></i> Add Consignments</button>';
        //     addConsDiv1 = document.getElementById('addConsignmentShort');
        //
        //
        //     addConsDiv1.innerHTML = '  <button type="button" style="" title="Add Consignments" disabled class="btn btn-secondary" id="addConsShortBtn" value=""> <i class="fa fa-add"></i></button>';
        //     // addConsDiv.children[0].children[0].disabled = true;
        //     //
        //     // addConsDiv.children[0].href = "";
        //     //
        //     // addConsDiv = document.getElementById('addConsignmentLong');
        //     //
        //     // addConsDiv.children[0].children[0].disabled = true;
        //     //
        //     // addConsDiv.children[0].href = "";
        //
        //
        // }



        if(document.getElementById('checkedOutShort') != null) {
            document.getElementById('checkedOutShort').disabled = true;
        }

        let editBtn = document.getElementById('editBtn001');
        const select = document.getElementById('inputVehicle');

        console.log(select);

let editDiv = document.getElementById('editBtn001Div');

        function edit(){

            // editBtn.style.visibility = 'hidden';

select.disabled = "";
            editDiv.innerHTML = '';
        editDiv.innerHTML = '<button class="btn btn-sm change-color2 rounded-2" onclick="save()" id="editBtn002" type="button" data-toggle="" data-placement="top" title="Save"><i class="fa fa-save"></i></button>';

        }

        let editBtn2 = document.getElementById('editBtn002');
        function save(){
            // editBtn.style.visibility = 'hidden';
            select.disabled = 'disabled';
            editDiv.innerHTML = '';
            editDiv.innerHTML = '<button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit()" id="editBtn001" type="button" data-toggle="" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';

        }




    </script>

    <script>
        let editBtn1 = document.getElementById('editBtnID');
        const select1 = document.getElementById('inputDriver');

        let editDiv1 = document.getElementById('btnDiv');

        function edit1(){
            // editBtn.style.visibility = 'hidden';
            select1.disabled = '';
            editDiv1.innerHTML = '';
            editDiv1.innerHTML = '<button class="btn btn-sm rounded-0 change-color2 rounded-2" onclick="save1()" id="saveBtnID" type="button" data-toggle="" data-placement="top" title="Save"><i class="fa fa-save"></i></button>';

        }

        let editBtn3 = document.getElementById('saveBtnID');
        function save1(){
            // editBtn.style.visibility = 'hidden';
            select1.disabled = 'disabled';
            editDiv1.innerHTML = '';
            editDiv1.innerHTML = '<button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit1()" id="editBtnID" type="button" data-toggle="" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';

        }

        </script>



<script>




    function addConsURL(){

        if(document.getElementById('inputVehicle').value == "-1") {

            swal({
                title: 'Error!',
                icon: 'error',
                text: 'Please select a Vehicle first!',

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
        }else{
        window.location.href = <?php echo json_encode("/frontend/add-consignments/".$deliverySheet->deliverySheet_id); ?>;
        }
    }

    $(document).ready(function () {


        {{--const status = <?php echo json_encode($deliverySheet->status); ?>;--}}

            const status = "un-checked-out";
        if(status  !== 'un-checked-out' ){
            addConsDiv = document.getElementById('addConsignmentLong');

            let editBtn = document.getElementById('editBtn001');
            editBtn.disabled = "true";
            editBtn.style.border = "none";

            let editBtnID = document.getElementById('editBtnID');
            editBtnID.disabled = "true";
            editBtnID.style.border = "none";

                addConsDiv.innerHTML = '<button type="button" style="" class="btn btn-secondary" id="addConsLongBtn" disabled value=""> <i class="fa fa-add"></i> Add Consignments</button>';
            addConsDiv1 = document.getElementById('addConsignmentShort');


        addConsDiv1.innerHTML = '  <button type="button" style="" title="Add Consignments" disabled class="btn btn-secondary" id="addConsShortBtn" value=""> <i class="fa fa-add"></i></button>';
                // addConsDiv.children[0].children[0].disabled = true;
            //
            // addConsDiv.children[0].href = "";
            //
            // addConsDiv = document.getElementById('addConsignmentLong');
            //
            // addConsDiv.children[0].children[0].disabled = true;
            //
            // addConsDiv.children[0].href = "";


        }


        $(document).on('change', '#inputVehicle', function () {
            let vehicleID = $(this).val();
            let dsID = document.getElementById("dsID").value;

            let str = vehicleID + "," + dsID;

            $.ajax(
                {

                    type: "GET",
                    url: "/frontend/vehicleAssignments/" + str,

                    success: function (response) {

                        if(response.drivers != null) {
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
                }
            );

        });


    });

    {{--let inputVehicle1 = document.getElementById("inputVehicle");--}}
    {{--let inputDriver1 = document.getElementById("inputDriver");--}}
    {{--let vehicleID1 = inputVehicle1.value;--}}
    {{--let driverID1 = inputDriver1.value;--}}

    {{--let size = <?php echo $size; ?>;--}}

    // if(vehicleID1 == "" || driverID1 == "" || size === 0){
    //     document.getElementsByClassName('btnCheckout')[0].disabled = "true";
    //     document.getElementsByClassName('btnCheckout')[1].disabled = "true";
    // }else{
    //     document.getElementsByClassName('btnCheckout')[0].disabled = "";
    //     document.getElementsByClassName('btnCheckout')[1].disabled = "";
    // }

    let inputVehicle = document.getElementById("inputVehicle");
    let alreadySelected = inputVehicle.value;


    $(document).ready(function () {

        //editBtn002 is save button of vehicleField
        $(document).on('click', '#editBtn002', function () {

            let dsID = document.getElementById("dsID").value;

            let inputVehicle = document.getElementById("inputVehicle");

            let inputDriver = document.getElementById("inputDriver");
            let vehicleID = inputVehicle.value;
if( alreadySelected !== vehicleID) {
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

            if(alreadySelectedDriver!== driverID) {

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

                // alert(vehicleID);
                // alert(driverID);
            }

        });

    });




</script>




    <script>
        $(document).ready(function(){
            $('.btnCheckout').click(function(e){
                e.preventDefault();

                let inputVehicle1 = document.getElementById("inputVehicle");
                let inputDriver1 = document.getElementById("inputDriver");
                let vehicleID1 = inputVehicle1.value;
                let driverID1 = inputDriver1.value;

                let size = <?php echo $size; ?>;


                if(size == 0){
                    swal({
                        title: 'Error!',
                        icon: 'error',
                        text: 'Please add some consignments!',

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
                }else if(vehicleID1 == "-1" || driverID1 == "-1"){
                    swal({
                        title: 'Error!',
                        icon: 'error',
                        text: 'Either Vehicle or Driver is not Assigned!',

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


                }else {


                    let deliverySheet_id = $(this).val();
                    $('#deliverySheet_id').val(deliverySheet_id);
                    $('#checkoutModal').modal('show');

                }

            });

        });
    </script>

    <script>
        $(document).ready(function(){
            $('.btnUnCheckout').click(function(e){
                e.preventDefault();
                let deliverySheet_id = $(this).val();
                $('#deliverySheet_idU').val(deliverySheet_id);
                $('#unCheckoutModal').modal('show');

            });

        });
    </script>




    <script>
                $(document).ready(function(){
                    $('.deleteConsignmentBtn').click(function(e){
                        e.preventDefault();
                        let cons_id = $(this).val();
                        $('#cons_id').val(cons_id);
                        $('#deleteModal').modal('show');

                    });

                });


                if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
                        window.history.back();
                }


    </script>


    <script>
        const allNewDivs = document.getElementsByClassName("newMessage");

        setTimeout(function(){
            for(let k=0; k<allNewDivs.length; k++) {
                $(".newMessage").fadeOut();
            }
        }, 2000);

    </script>

@endsection





