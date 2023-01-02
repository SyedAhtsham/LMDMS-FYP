@extends('frontend.layouts.main')
@section('main-container')


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('vehicle.delete')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Delete Vehicle</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="vehicle_delete_id" id="vehicle_id" />
                        <h5>Are you sure you want to delete this <b><i>Vehicle record</i></b> and any related <b><i>Vehicle Assignments</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" style="background-color: rgb(0, 74, 111);" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="main pt-5" style="margin-right: 2em;" >

        <h4>Delivery Sheets</h4>
        <hr>

        <div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">


                    <form id="myForm0" action="">
                        <input type="hidden" name="search" value="">
                        @if(isset($search) && $search!="checked-out" && $search!="un-checked-out" || $search=="")
                            <a class="nav-link active" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>
                        @else
                            <a class="nav-link" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>
                        @endif
                    </form>
                </li>
                <li class="nav-item">
                    <form id="myForm1" action="">
                        <input type="hidden" name="search" value="checked-out">
                        @if(isset($search) && $search=="checked-out")
                            <a class="nav-link active" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>
                        @else
                            <a class="nav-link" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>
                        @endif
                    </form>
                </li>
                <li class="nav-item">
                    <form id="myForm2" action="">
                        <input type="hidden" name="search" value="un-checked-out">
                        @if(isset($search) && $search=="un-checked-out")
                            <a class="nav-link active" id="alink3" data-toggle="tab" href="" onclick="submitFormFun2()" role="tab" aria-controls="contact" aria-selected="false">Un-checked out</a>
                        @else
                            <a class="nav-link" id="alink3" data-toggle="tab" href="" onclick="submitFormFun2()" role="tab" aria-controls="contact" aria-selected="false">Un-checked out</a>
                        @endif
                    </form>
                </li>
                <div>
                </div>
                <div class="ml-5">
                    <form action="" class="col-15 d-flex">
                        <div class="form-group col-8">
                            <input type="search" name="search" id="" class="form-control" value="{{($search=="checked-out" || $search=="un-checked-out") ? "" : $search}}" placeholder="Search by sheet id, driver id, vehicle id, area code..">
                        </div>
                        <div class="">
                            <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                                    class="btn btn-primary">Search
                            </button>
                        </div>

                        <div class="col-2">
                            <a href="{{url('/frontend/view-deliverysheets')}}">
                                <button type="button" style="width: 8em;"
                                        class="btn btn-light">Reset
                                </button>
                            </a>
                        </div>
                        <div class="ml-lg-5">
                            @if(!$newConsignments)
                            <button type="button" class="btn btn-success" title="Generate Delivery Sheets" disabled ><i class="fa fa-plus"></i> Delivery Sheets</button>

                        @else
                            <a href="{{url('/frontend/generateDSheet')}}">
{{--                                <button type="button" style="width: 11em;"--}}
{{--                                        class="btn btn-success">Generate Delivery Sheets--}}
{{--                                </button>--}}
                                <button type="button" class="btn btn-success" title="Generate Delivery Sheets" ><i class="fa fa-plus"></i> Delivery Sheets</button>
                            </a>

                            @endif
                        </div>
                    </form>
                </div>


                </li>
            </ul>

<br>
            <table  class="table table-sm table-striped table-dark" >
                <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
                <tr>
                    <th>Sr #</th>
                    <th>DS #</th>
                    <th>Area</th>
                    {{--            <th>Email</th>--}}
                    <th>Driver</th>

                    <th>Supervisor</th>
                    <th>Quantity</th>
                    <th>Fuel</th>
                    <th>Check-out time</th>
                    {{--            <th>CNIC</th>--}}

                    <th>Action</th>
                </tr>
                </thead>

                <tbody>

                <tr>
                    @php
                        $i = 0;
                        $size = sizeof($deliverySheets);

                    @endphp
                    @if($size<=0)
                </tr>
            </table>

            <center><i> Sorry, no record found! </i></center>
            @else
                @foreach($deliverySheets as $member)


                    <td>
                        <div class="d-inline-flex">
                            <div>
                                {{++$i}}
                            </div>
                            @php
                                $createdAt = strtotime(\Carbon\Carbon::parse($member->created_at));
                                $currentDate = time();

                                $diff = ($currentDate-$createdAt)/3600;

                                if($diff <= 1){

                         echo '<div class="bg-warning rounded ml-1" style="width: 2.5em; text-align: center;">
                              New
                         </div>';
                             }
                            @endphp
                        </div>
                    </td>


                    <td>{{$member->deliverySheetCode}}</td>
{{--                    <td>{{$member->arNM.", ".$member->arCT." (".$member->arCD.")"}}</td>--}}
                    <td>{{$member->arNM." (".$member->arCD.")"}}</td>
                    {{--            <td>{{$member->email}}</td>--}}
                    <td>{{$member->drvName}}</td>



                    @if(isset($member->spvName))

                        <td>{{$member->spvName}}</td>

                    @else

                        <td>---</td>


                    @endif

                    <td>{{$member->noOfCons}}</td>
                    <td>{{$member->fuelAssigned}}</td>


                    @if(isset($member->checkOutTime))

                        <td>{{$member->checkOutTime}}</td>

                    @else

                        <td>---</td>


                    @endif


                    <td>
                        <!-- Call to action buttons -->

                        <ul class="list-inline m-0">

                            {{--                    <li class="list-inline-item">--}}
                            {{--                       <a href="{{url('/frontend/edit-staff/{id}')}}">--}}
                            {{--                        <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
                            {{--                       </a>--}}
                            {{--                    </li>--}}
{{--                            @if((isset($search) && $search=="checked-out") || $member->status == "un-checked-out")--}}
                                <li class="list-inline-item">
                                    <a href="{{route('view.deliverysheet', ['id'=>$member->deliverySheet_id])}}">
                                        <button class="btn btn-sm rounded-0 change-color0" type="button" data-toggle="tooltip" data-placement="top" title="View"><i class="fa-solid fa-eye"></i></button>
                                    </a>
                                </li>
{{--                            @else--}}
{{--                                <li class="list-inline-item">--}}

{{--                                    <button class="btn btn-sm rounded-0" type="button" data-toggle="tooltip" disabled data-placement="top" title="Assign"><i class="fa fa-add"></i></button>--}}

{{--                                </li>--}}
{{--                            @endif--}}

                            <li class="list-inline-item">
                                <a href="{{route('vehicle.edit', ['id'=>$member->deliverySheet_id])}}">
                                    <button class="btn btn-sm rounded-0 change-color"  id="editBtn" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
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
                                <button class="btn btn-sm rounded-0 deleteVehicleBtn change-color1" type="button" data-toggle="tooltip" data-placement="top" title="Delete" value="{{$member->deliverySheet_id}}"><i class="fa fa-trash"></i></button>
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
                        {{$deliverySheets->links()}}
                    </div>


        </div>


        @endsection


        @section('scripts')
            <script>
                $(document).ready(function(){
                    $('.deleteVehicleBtn').click(function(e){
                        e.preventDefault();
                        var vehicle_id = $(this).val();
                        $('#vehicle_id').val(vehicle_id);
                        $('#deleteModal').modal('show');

                    });

                });
            </script>

@endsection
