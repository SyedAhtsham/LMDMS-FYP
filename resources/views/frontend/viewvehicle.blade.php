@extends('frontend.layouts.main')
@section('main-container')

    {{--    <!-- Modal -->--}}
    {{--    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
    {{--        <div class="modal-dialog" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="exampleModalLabel">Delete Vehicle</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <form action="{{route('vehicle.delete')}}" method="POST">--}}
    {{--                <div class="modal-body">--}}

    {{--                    @csrf--}}
    {{--                        <input type="hidden" name="vehicle_delete_id" id="vehicle_id" />--}}
    {{--                        <h5>Are you sure you want to delete this <b><i>Vehicle record</i></b> and any related <b><i>Vehicle Assignments</i></b>?</h5>--}}

    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="submit" class="btn btn-danger">Yes Delete</button>--}}
    {{--                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>--}}
    {{--                </div>--}}
    {{--                </form>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('vehicle.delete')}}" method="POST">
                        @csrf

                        <input type="hidden" name="vehicle_delete_id" id="vehicle_id0" value=""/>
                        <h6>Are you sure you want to delete this <b><i>Vehicle record</i></b> and any related <b><i>Vehicle
                                    Assignments</i></b>?</h6>
<hr>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Vehicle Code:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="vehicleCode0" class="form-control-plaintext" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Plate No:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="plateNo0" class="form-control-plaintext" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label"><strong>Make & Type:</strong></label>
                            <div class="col-sm-5">
                                <input type="text" readonly id="vehicleType0" class="form-control-plaintext" value="">
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Yes Delete</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
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
                            <label for="sel1" class="form-label">Select Driver <span class="required">*</span></label>
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


        <div class="main pt-5" style="margin-right: 2em;">

            <h4>Vehicles</h4>
            <hr>

            <div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">


                        <form id="myForm0" action="">
                            <input type="hidden" name="search" value="">
                            @if(isset($search) && $search!="Unassigned" && $search!="Assigned" || $search=="")
                                <a class="nav-link active" id="alink0" data-toggle="tab" href=""
                                   onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>
                            @else
                                <a class="nav-link" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()"
                                   role="tab" aria-controls="profile" aria-selected="false">All</a>
                            @endif
                        </form>
                    </li>
                    <li class="nav-item">
                        <form id="myForm1" action="">
                            <input type="hidden" name="search" value="Assigned">
                            @if(isset($search) && $search=="Assigned")
                                <a class="nav-link active" id="alink2" data-toggle="tab" href=""
                                   onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Assigned</a>
                            @else
                                <a class="nav-link" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()"
                                   role="tab" aria-controls="profile" aria-selected="false">Assigned</a>
                            @endif
                        </form>
                    </li>
                    <li class="nav-item">
                        <form id="myForm2" action="">
                            <input type="hidden" name="search" value="Unassigned">
                            @if(isset($search) && $search=="Unassigned")
                                <a class="nav-link active" id="alink3" data-toggle="tab" href=""
                                   onclick="submitFormFun2()" role="tab" aria-controls="contact" aria-selected="false">Un-assigned</a>
                            @else
                                <a class="nav-link" id="alink3" data-toggle="tab" href="" onclick="submitFormFun2()"
                                   role="tab" aria-controls="contact" aria-selected="false">Un-assigned</a>
                            @endif
                        </form>
                    </li>
                    <div>
                    </div>
                    <div class="ml-5">
                        <form action="" class="col-15 d-flex">
                            <div class="form-group col-10">
                                <input type="search" name="search" id="" class="form-control"
                                       value="{{($search=="Assigned" || $search=="Unassigned") ? "" : $search}}"
                                       placeholder="Search by name, vehicle id, condition, status..">
                            </div>
                            <div class="">
                                <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                                        class="btn btn-primary">Search
                                </button>
                            </div>

                            <div class="col-2">
                                <a href="{{url('/frontend/view-vehicle')}}">
                                    <button type="button" style="width: 8em;"
                                            class="btn btn-light">Reset
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
                    </li>
                </ul>

                {{--        <div class="row mt-2 mb-2 d-flex">--}}
                {{--            <div class="col-14 d-flex">--}}

                {{--                <div class="">--}}

                {{--                    <a href="{{url('/frontend/view-vehicle')}}">--}}
                {{--                        <button id="btn1" type="button" style="width: 8em;"--}}
                {{--                                class="btn btn-light change-color">All--}}
                {{--                        </button>--}}
                {{--                    </a>--}}
                {{--                </div>--}}

                {{--                <div class="col-4">--}}
                {{--                    <form action="">--}}
                {{--                        <input type="hidden" name="search" value="Assigned">--}}
                {{--                    <button id="btn2" type="submit" name="search" style="width: 8em;"--}}
                {{--                            class="btn btn-light change-color">Assigned--}}
                {{--                    </button>--}}
                {{--                    </form>--}}
                {{--                </div>--}}
                {{--                <div class="col-2">--}}
                {{--                    <form action="">--}}
                {{--                        <input type="hidden" name="search" value="Unassigned">--}}
                {{--                        <button id="btn3" type="submit" style="width: 8em;"--}}
                {{--                                class="btn btn-light change-color">Un-assigned--}}
                {{--                        </button>--}}
                {{--                    </form>--}}
                {{--                </div>--}}

                {{--            </div>--}}

                {{--        </div>--}}

                {{--        <hr>--}}

                {{--        <div class="row mt-2 mb-2 d-flex">--}}
                {{--            <form action="" class="col-10 d-flex">--}}
                {{--                <div class="form-group col-7">--}}
                {{--                    <input type="search" name="search" id="" class="form-control" value="{{$search}}" placeholder="Search by name, vehicle id, condition, status..">--}}
                {{--                </div>--}}
                {{--                <div class="">--}}
                {{--                    <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"--}}
                {{--                            class="btn btn-primary">Search--}}
                {{--                    </button>--}}
                {{--                </div>--}}

                {{--                <div class="col-2">--}}
                {{--                    <a href="{{url('/frontend/view-vehicle')}}">--}}
                {{--                        <button type="button" style="width: 8em;"--}}
                {{--                                class="btn btn-light">Reset--}}
                {{--                        </button>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--            </form>--}}

                {{--        </div>--}}
                <br>

                <table class="table table-sm table-striped">
                    <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
                    <tr>

                        <th>Sr #</th>
                        <th>Veh #</th>
                        <th>Make</th>
                        {{--            <th>Email</th>--}}
                        <th>Plate No.</th>

                        <th>Type</th>
                        <th>Ownership</th>
                        <th>Purchase/Contract Date</th>
                        <th>Cost in PKR</th>
                        {{--            <th>CNIC</th>--}}
                        <th>Condition</th>
                        {{--            <th>DOB</th>--}}
                        <th>Status</th>

                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        @php
                            $i = 1;
                            $size = sizeof($vehicle);

                        @endphp
                        @if($size<=0)
                    </tr>
                </table>

                <center><i> Sorry, no record found! </i></center>
                @else
                    @foreach($vehicle as $member)

                        <td>
                            <div class="d-inline-flex">
                                <div>
                                    @php
                                    $total = (($vehicle->currentPage()-1) * 20) + $i;
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
                        <td>{{$member->vehicleCode}}</td>
                        <td>{{$member->make}}</td>
                        {{--            <td>{{$member->email}}</td>--}}
                        <td>{{$member->plateNo}}</td>

                        <td>
                            @if($member->getVehicleType->typeName == 'Bike')

                                <i class="fa fa-motorcycle fa-lg"></i>
                            @elseif($member->getVehicleType->typeName == 'Shahzore')
                                <i class="fa fa-truck-moving fa-lg"></i>
                            @elseif($member->getVehicleType->typeName == 'Carry')
                                <i class="fas fa-shuttle-van fa-lg"></i>
                            @elseif($member->getVehicleType->typeName == 'Hilux')
                                <i class="fas fa-truck fa-lg"></i>
                            @endif



                                </td>



                        @if(isset($member->getCompVehicle))

                            <td>Company</td>
                            <td>
                                {{$member->getCompVehicle->getPurchasedDate($member->getCompVehicle->purchasedDate)}}
                            </td>
                            <td>
                                {{$member->getCompVehicle->price}}
                            </td>

                        @elseif(isset($member->getContVehicle))
                            <td>Contractual</td>
                            <td>
                                {{$member->getContVehicle->getDateOfContract($member->getContVehicle->dateOfContract)}}
                            </td>
                            <td>
                                {{$member->getContVehicle->rentPerDay}}
                            </td>
                        @else

                            <td>---</td>
                            <td>
                                ---
                            </td>
                            <td>
                                ---
                            </td>

                        @endif

                        {{--            <td>{{$member->cnic}}</td>--}}
                        @if($member->condition == "Bad")

                            <td>
                                <div class="text-bg-danger rounded" style="width: 2.5em;  text-align: center;">
                                    {{$member->condition}}

                            </div>
                            </td>
                        @else
                            <td>
                                {{$member->condition}}
                            </td>
                        @endif
                        {{--
                                                <td>{{$member->getDob($member->dob)}}</td>--}}
                        @if($member->status == "Active")
                            <td style="color: forestgreen;">
                                {{$member->status}}
                            </td>
                        @else
                            <td>
                                {{$member->status}}
                            </td>
                        @endif

                        {{--                @if($member->position == "Driver")--}}


                        {{--                    <td>{{$member->getDriver->licenseNo ?? '---'}}</td>--}}

                        {{--                    --}}{{--                <td>{{$member['getDriver']['yearsExp']}}</td>--}}
                        {{--                    <td>{{$member->getDriver->canDrive ?? '---'}}</td>--}}


                        {{--                @else--}}
                        {{--                    <td>---</td>--}}
                        {{--                    --}}{{--                    <td>---</td>--}}
                        {{--                    <td>---</td>--}}

                        {{--                @endif--}}

                        <td>
                            <!-- Call to action buttons -->

                            <ul class="list-inline m-0">

                                {{--                    <li class="list-inline-item">--}}
                                {{--                       <a href="{{urlfaddBtn('/frontend/edit-staff/{id}')}}">--}}
                                {{--                        <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
                                {{--                       </a>--}}
                                {{--                    </li>--}}
                                @if((isset($search) && $search=="Unassigned") || $member->assignStatus == "Unassigned")
                                    <li class="list-inline-item">
                                        {{--                            <a href="{{route('vehicle.assign', ['id'=>$member->vehicle_id])}}">--}}
                                        <button class="btn btn-sm rounded-0 addBtn change-color0" value="{{$member}}"
                                                type="button" data-toggle="modal" data-placement="top" title="Assign"
                                                data-target="#exampleModal"><i class="fa fa-add"></i></button>
                                        {{--                            </a>--}}
                                    </li>
                                @else
                                    <li class="list-inline-item">

                                        <button class="btn btn-sm rounded-0" style="border: none;" type="button"
                                                data-toggle="tooltip" disabled data-placement="top" title="Assign"><i
                                                class="fa fa-add"></i></button>

                                    </li>
                                @endif

                                <li class="list-inline-item">
                                    <a href="{{route('vehicle.edit', ['id'=>$member->vehicle_id])}}">
                                        <button class="btn btn-sm rounded-0 change-color" id="editBtn" type="button"
                                                data-toggle="" data-placement="top" title="Edit"><i
                                                   class="fa fa-edit"></i></button>
                                    </a>
                                </li>
                                {{--                    <li class="list-inline-item">--}}
                                {{--                        <a href="{{url('/frontend/delete-staff/'.$member->staff_id)}}">--}}
                                {{--                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                                {{--                        </a>--}}
                                {{--                    </li>--}}
                                <li class="list-inline-item">
                                    {{--                            <a href="{{route('vehicle.delete', ['id'=>$member->vehicle_id])}}">--}}
                                    {{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                                    <button class="btn btn-sm rounded-0 deleteVehicleBtn change-color1" type="button"
                                            data-toggle="modal" data-placement="top" title="Delete"
                                            data-target="#deleteModal" value="{{$member}}"><i
                                            class="fa fa-trash"></i></button>
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
                            {{$vehicle->links()}}

                        </div>


            </div>


            @endsection


            @section('scripts')
                <script>
                    // $(document).ready(function(){
                    //     $('.deleteVehicleBtn').click(function(e){
                    //         e.preventDefault();
                    //         var vehicle_id = $(this).val();
                    //         $('#vehicle_id').val(vehicle_id);
                    //         $('#deleteModal').modal('show');
                    //
                    //     });
                    //
                    // });

                    $(document).ready(function () {
                        $(document).on('click', '.deleteVehicleBtn', function () {
                            let vehicleJSONText = $(this).val();

                            let vehicle = JSON.parse(vehicleJSONText);

                            // alert(vehicleId);
                            let vehicleType = vehicle['get_vehicle_type']['typeName'];
                            let makeAndType = vehicle['make'] + " " + vehicleType;
                            console.log(vehicle);
                            // console.log(vehicleType['typeName']);


                                        $('#vehicleCode0').val(vehicle['vehicleCode']);
                                        $('#plateNo0').val(vehicle['plateNo']);
                                        $('#vehicleType0').val(makeAndType);
                            $('#vehicle_id0').val(vehicle['vehicle_id']);
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

@endsection
