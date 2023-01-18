@extends('frontend.layouts.main')
@section('title', $vehicle->vehicleCode)

@section('main-container')


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('vehicle.delete')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Delete Vehicle</h3>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="vehicle_delete_id" id="staff_id"  />
                        <h5>Are you sure you want to delete this <b><i>Vehicle</i></b> and any related <b><i>Vehicle Assignments</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal to assign a vehicle to a driver -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Vehicle Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('vehicle.assignment')}}" method="POST">
                        @csrf

                        <input type="hidden" name="vehicleId" id="vehicleId" value="" />

                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Vehicle Code:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="vehicleCode" class="form-control-plaintext"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Plate No:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="plateNo" class="form-control-plaintext" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Make & Type:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="vehicleType" class="form-control-plaintext"
                                       value="">
                            </div>
                        </div>


                        <div class="mt-4">
                            <label for="sel1" class="form-label">Select Driver <span class="required">*</span> <label class=" small"> (the following drivers can drive this vehicle)</label></label>
                            <select class="form-select" id="driver" name="driver">

                            </select>


                        </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" id="assignBtn" class="btn btn-primary" style="background-color: rgb(0, 74, 111);">Assign
                        Driver
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <div class="container pt-5">
    </div>
    <div class="main">

        <div>
            <div class="float-left">
                <h4 class=" float-left">
                    @if($vehicleType->typeName == 'Bike')

                        <i class="fa fa-motorcycle fa-lg"></i>
                    @elseif($vehicleType->typeName == 'Shahzore')
                        <i class="fa fa-truck-moving fa-lg"></i>
                    @elseif($vehicleType->typeName == 'Carry')
                        <i class="fas fa-shuttle-van fa-lg"></i>
                    @elseif($vehicleType->typeName == 'Hilux')
                        <i class="fas fa-truck fa-lg"></i>
                    @elseif($vehicleType->typeName == 'Van')
                        <i class="fas fa-truck-field fa-lg"></i>
                    @endif {{$vehicle->vehicleCode}}
                    @if(isset($vehicle->deleted_at))

                        <label class="small text-danger"> (ex-fleet member) </label>

                        @endif

                    </label></h4>
            </div>
            @if(!isset($vehicle->deleted_at))

                @if(Session::get('position') != "Driver")
            <div class="form-group float-right mr-5 mb-3 d-flex">

                <a href="{{route('vehicle.edit', ['id'=>$vehicle->vehicle_id])}}">
                    <button type="button" class="btn text-white mr-3" style="background-color:rgb(11, 77, 114);"><i class="fa-solid fa-edit mr-1"></i> Edit</button>
                </a>
                <button type="button" class="btn btn-danger text-white deleteStaffBtn" value="{{$vehicle->vehicle_id}}"><i class="fa fa-trash mr-1"></i> Delete</button>
            </div>
                @endif
                @endif
        </div>
        <br>
        <hr>


        <div class="container bootstrap snippets bootdey mt-4">
            <div class="panel-body inf-content">
                <div class="row">

                    <div class="col-md-7 ml-3 mt-2">


                        <div class="table-responsive">
                            <table class="table table-user-information">
                                <tbody>

                                <tr>

                                    <td>
                                        <strong style="font-size: 20px;">Basic Information</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <br> <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                            <i class="fa-solid fa-hashtag mr-1"></i> Vehicle Code
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        <br> {{$vehicle->vehicleCode}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-user  text-primary"></span>
                                            <i class="fa-solid fa-copyright  mr-1"></i> Make
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$vehicle->make}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-cloud text-primary"></span>
                                            <i class="fa-solid fa-typo3  mr-1"></i> Type
                                        </strong>
                                    </td>
                                    <td class="text-primary">

                                        @if($vehicleType->typeName == 'Bike')

                                            <i class="fa fa-motorcycle fa-lg"></i>
                                        @elseif($vehicleType->typeName == 'Shahzore')
                                            <i class="fa fa-truck-moving fa-lg"></i>
                                        @elseif($vehicleType->typeName == 'Carry')
                                            <i class="fas fa-shuttle-van fa-lg"></i>
                                        @elseif($vehicleType->typeName == 'Hilux')
                                            <i class="fas fa-truck fa-lg"></i>
                                        @elseif($vehicleType->typeName == 'Van')
                                            <i class="fas fa-truck-field fa-lg"></i>
                                        @endif

                                            {{$vehicleType->typeName}}

                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                            <i class="fa-solid fa-rectangle-ad mr-1"></i> Plate No.
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$vehicle->plateNo}}
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-eye-open text-primary"></span>
                                            <i class="fa-solid fa-y  mr-1"></i> Model
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$vehicle->vehicleModel}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-envelope text-primary"></span>
                                            <i class="fa-solid fa-c  mr-1"></i> Condition
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                    @if($vehicle->condition == "Bad")


                                            <div class="text-bg-danger rounded" style="width: 2.5em;  text-align: center;">
                                                {{$vehicle->condition}}

                                            </div>

                                    @else

                                            {{$vehicle->condition}}

                                        @endif

                                    </td>
                                </tr>

                                @if(!isset($vehicle->deleted_at))
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            <i class="fa-solid fa-question-circle  mr-1"></i>  Status
                                        </strong>
                                    </td>
                                    <td class="text-primary">

                                        @if($vehicle->status == "Idle")
                                            <i class="fa-solid fa-circle text-warning small mr-1"></i>{{$vehicle->status}}
                                        @elseif($vehicle->status == "Active")
                                            <i class="fa-solid fa-circle  small mr-1" style="color: rgb(28, 198, 88);"></i>{{$vehicle->status}}
                                        @elseif($vehicle->status == "In-Workshop")
                                            <i class="fa-solid fa-circle text-danger small mr-1"></i>{{$vehicle->status}}

                                        @endif
                                    </td>
                                </tr>
@endif

                                    <tr><td><br></td></tr>
                                    <tr>
                                        <td>  <strong style="font-size: 20px;">Additional Information</strong> </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>
                                                <br> <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                <i class="fa-regular fa-w  mr-1"></i>  Weight Capacity
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            <br> {{$vehicleType->weightCap}} kg
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-user  text-primary"></span>
                                                <i class="fa-solid fa-v mr-1"></i> Volume Capacity
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{$vehicleType->volumeCap}} m<sup>3</sup>
                                        </td>
                                    </tr>

                                @if(!isset($vehicle->deleted_at))

                                    @if(( \Illuminate\Support\Facades\Session::get('position') == "Driver" && (\Illuminate\Support\Facades\Session::get('staff_id') == $driver->staff_id)))
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-cloud text-primary"></span>
                                                <i class="fa-solid fa-user-circle-o  mr-1"></i> Assigned To
                                            </strong>
                                        </td>
                                        <td class="text-primary">

                                            @if(isset($driver->staffCode))
                                                <a href="{{route('view.singlestaff', ['id'=>$driver->staff_id])}}">
                                            {{$driver->staffCode}}
                                                </a>
                                            @else
                                            --- <button class="btn btn-sm rounded-2 addBtn btn-primary ml-2 float-right" value="{{$vehicleData}}"
                                                        type="button" data-toggle="modal" data-placement="top" title="Assign"
                                                        data-target="#exampleModal"><i class="fa fa-add"></i> Assign</button>
                                                @endif
                                        </td>
                                    </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-cloud text-primary"></span>
                                            <i class="fa-solid fa-user  mr-1"></i> Assigned By
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        @if(isset($supervisor->staffCode))
                                            <a href="{{route('view.singlestaff', ['id'=>$supervisor->staff_id])}}">
                                            {{$supervisor->staffCode}}
                                            </a>
                                            <label class="text-black ml-2"> on</label>
                                            @if(isset($supervisor->staffCode))
                                                    <?php
                                                    $date = date("d-m-Y",strtotime($vehicleAssignment->dateAssigned));
                                                    ?>
                                                {{$date}}

                                            @else
                                                ---
                                            @endif
                                        @else
                                            ---
                                        @endif
                                    </td>
                                </tr>

                                    @endif

                                    @if(\Illuminate\Support\Facades\Session::get('position') != "Driver")
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                            <i class="fa-solid fa-file  mr-1"></i> DeliverySheet Assigned
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        @if(isset($dSheet))
                                            <a href="{{route('view.deliverysheet', ['id'=>$dSheet->deliverySheet_id])}}">
                                                {{$dSheet->deliverySheetCode}}
                                            </a>
                                        @else
                                            ---
                                        @endif

                                    </td>
                                </tr>

                                        @endif
@endif




                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <br>
        <br>
        <br>



        @endsection

        @section('scripts')

            <script>
                function myFunction() {
                    let x = document.getElementById("myInput");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }


                let editDiv = document.getElementById('editBtn001Div');
                let password = document.getElementById('myInput');
                function edit(){

                    // editBtn.style.visibility = 'hidden';


                    password.disabled = "";

                    editDiv.innerHTML = '';
                    editDiv.innerHTML = '<button class="btn btn-sm change-color0 rounded-2" onclick="save()" id="editBtn002" type="button" data-toggle="" data-placement="top" title="Save"><i class="fa fa-save"></i></button>';

                }

                let editBtn2 = document.getElementById('editBtn002');
                function save(){
                    // editBtn.style.visibility = 'hidden';

                    let password = document.getElementById("myInput").value;


                    if(password.length < 4){
                        swal({
                            title: 'Error!',
                            icon: 'error',
                            text: 'Password must have at least 4 characters!',

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
                    }else {


                        password.disabled = 'disabled';
                        editDiv.innerHTML = '';
                        editDiv.innerHTML = '<button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit()" id="editBtn001" type="button" data-toggle="" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    }
                }

                $(document).ready(function () {

                    //editBtn002 is save button of vehicleField
                    $(document).on('click', '#editBtn002', function () {

                        let staffID = document.getElementById("staffID").value;


                        let password = document.getElementById("myInput").value;


                        if(password.length < 4){
                            swal({
                                title: 'Error!',
                                icon: 'error',
                                text: 'Password must have at least 4 characters!',

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
                        }else {


                            let str = staffID + "," + password;
                            $.ajax(
                                {

                                    type: "GET",
                                    url: "/frontend/changePassword/" + str,

                                    success: function (response) {

                                        swal({
                                            title: 'Success!',
                                            icon: 'success',
                                            text: 'Password changed successfully!',

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
                        // alert(vehicleID);
                        // alert(driverID);

                    });

                });


                $(document).ready(function(){
                    $('.deleteStaffBtn').click(function(e){
                        e.preventDefault();
                        var staff_id = $(this).val();
                        $('#staff_id').val(staff_id);
                        $('#deleteModal').modal('show');

                    });

                });


                $(document).ready(function () {
                    $(document).on('click', '.addBtn', function () {
                        let vehicleJSONText = $(this).val();

                        let vehicle = JSON.parse(vehicleJSONText);

                        // alert(vehicleId);
                        let vehicleType = vehicle['get_vehicle_type']['typeName'];
                        let makeAndType = vehicle['make'] + " " + vehicleType;
                        // console.log(vehicle);
                        // console.log(vehicleType['typeName']);

                        $('#vehicleCode').val(vehicle['vehicleCode']);
                        $('#plateNo').val(vehicle['plateNo']);
                        $('#vehicleType').val(makeAndType);
                        $('#vehicleId').val(vehicle['vehicle_id']);

                        $.ajax(
                            {
                                type: "GET",
                                url: "/frontend/vehicle-assignment/" + vehicleType,
                                success: function (response) {
                                    let drivers = response.drivers;
                                    let driverSelect = document.getElementById('driver');

                                    // console.log(drivers);
                                    while (driverSelect.children[0]) {
                                        driverSelect.removeChild(driverSelect.lastChild);
                                    }

                                    document.getElementById('assignBtn').disabled = '';
                                    if (drivers.length === 0) {
                                        let optionElement = document.createElement('option');
                                        optionElement.innerHTML = '<label style="color: red;">Sorry, no driver found</label>';
                                        driverSelect.appendChild(optionElement);
                                        document.getElementById('assignBtn').disabled = 'true';

                                    }



                                    for (let i = 0; i < drivers.length; i++) {
                                        let optionElement = document.createElement('option');
                                        optionElement.innerHTML = drivers[i].stName;
                                        // console.log(drivers[i]);
                                        optionElement.value = drivers[i].staffId;
                                        driverSelect.appendChild(optionElement);
                                    }


                                }
                            }
                        );

                    });

                });

            </script>

    <script>
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.history.back();
        }


    </script>

@endsection
