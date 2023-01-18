@extends('frontend.layouts.main')
@section('title', "Delivery Sheets | ")
@section('main-container')


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('deliverySheet.delete')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Delete Delivery Sheet</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="vehicle_delete_id" id="vehicle_id" />
                        <h5>Are you sure you want to delete this <b>Delivery Sheet</b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
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
                        @if(isset($statusView) && $statusView!="checked-out" && $statusView!="un-checked-out" || $statusView=="")
                            <a class="nav-link active" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>
                        @else
                            <a class="nav-link" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>
                        @endif
                    </form>
                </li>
                <li class="nav-item">
                    <form id="myForm1" action="">
                        <input type="hidden" name="search" value="checked-out">
                        @if(isset($statusView) && $statusView=="checked-out")
                            <a class="nav-link active" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>
                        @else
                            <a class="nav-link" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>
                        @endif
                    </form>
                </li>
                <li class="nav-item">
                    <form id="myForm2" action="">
                        <input type="hidden" name="search" value="un-checked-out">
                        @if(isset($statusView) && $statusView=="un-checked-out")
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

                            <input type="search" name="search" id="" class="form-control" value="{{($search=="checked-out" || $search=="un-checked-out") ? ('in:'. strtolower($search) . ' ') : $search}}" placeholder="Search by sheet id, driver id, vehicle id, area code..">
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
            <table  class="table table-sm table-striped" >
                <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
                <tr>
                    <th class="" style="width: 65px;">Sr #</th>
                    <th>DS Code</th>
                    <th>Area</th>
                    {{--            <th>Email</th>--}}
                    <th>Driver</th>

                    <th>Supervisor</th>
                    <th>Vehicle</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Fuel</th>
                    <th>Check-out time</th>
                    {{--            <th>CNIC</th>--}}

                    <th class="text-center">Action</th>
                </tr>
                </thead>

                <tbody>

                <tr>
                    @php
                        $i = 1;
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
                                @php
                                    $total = (($deliverySheets->currentPage()-1) * 20) + $i;
                                    echo $total;

                                    $i++;
                                @endphp
                            </div>
                            @php
                                $createdAt = strtotime(\Carbon\Carbon::parse($member->created_at));
                                $currentDate = time();

                                $diff = ($currentDate-$createdAt)/3600;

                                if($diff <= 1){

                         echo '<div class="bg-warning rounded ml-1 newMessage" style="width: 2.5em; text-align: center;">
                              New
                         </div>';
                             }
                            @endphp
                        </div>
                    </td>



                    <td>
                        <a href="{{route('view.deliverysheet', ['id'=>$member->deliverySheet_id])}}">
                        {{$member->deliverySheetCode}}
                        </a>
                    </td>
{{--                    <td>{{$member->arNM.", ".$member->arCT." (".$member->arCD.")"}}</td>--}}
                    <td>{{$member->arNM." (".$member->arCD.")"}}</td>
                    {{--            <td>{{$member->email}}</td>--}}
                    @if(isset($member->drvName))

                        <td>
                            @if(isset($member->stID))
                            <a href="{{route('view.singlestaff', ['id'=>$member->stID])}}">
                            {{$member->drvName}}
                            </a>
                            @endif
                        </td>

                    @else

                        <td>---</td>


                    @endif


                @if(isset($member->spvName))


                        <td>
                            <a href="{{route('view.singlestaff', ['id'=>$member->stID])}}">{{$member->spvName}}
                            </a>
                        </td>

                    @else

                        <td>---</td>


                    @endif


                    <td>
                        @if(isset($member->vhCode))
                            <a href="{{route('view.singlevehicle', ['id'=>$member->vhID])}}">
                            {{$member->vhCode}}
                            </a>
                        @else
                            ---
                        @endif



                    </td>

                    <td>
                        @if($member->tpName == 'Bike')

                            <i class="fa fa-motorcycle fa-lg"></i>
                        @elseif($member->tpName == 'Shahzore')
                            <i class="fa fa-truck-moving fa-lg"></i>
                        @elseif($member->tpName == 'Carry')
                            <i class="fas fa-shuttle-van fa-lg"></i>
                        @elseif($member->tpName == 'Hilux')
                            <i class="fas fa-truck fa-lg"></i>
                        @elseif($member->tpName == 'Van')
                            <i class="fas fa-truck-field fa-lg"></i>
                        @else
                            ---
                        @endif

                    </td>


                    <td>{{$member->noOfCons}}</td>
                    <td>{{$member->fuelAssigned}} ltr</td>


                    @if(isset($member->checkOutTime))

                        <td>{{
                               date('d-M-Y H:i:s', strtotime($member->checkOutTime))
                                }}</td>

                    @else

                        <td>---</td>


                    @endif


                    <td class="text-center">
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
                                        <button class="btn btn-sm rounded-2 change-color0" type="button"  data-placement="top" title="View"><i class="fa-solid fa-eye"></i></button>
                                    </a>
                                </li>
                            @if($member->status == 'checked-out')
                            <li class="list-inline-item">
                                {{--                            <a href="{{route('vehicle.delete', ['id'=>$member->vehicle_id])}}">--}}
                                {{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                                <button class="btn btn-sm rounded-2 border-0 deleteVehicleBtn change-color1" disabled type="button"  data-placement="top" title="Delete" value="{{$member->deliverySheet_id}}"><i class="fa fa-trash"></i></button>
                                {{--                            </a>--}}
                            </li>
                            @else
                                <li class="list-inline-item">
                                    {{--                            <a href="{{route('vehicle.delete', ['id'=>$member->vehicle_id])}}">--}}
                                    {{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                                    <button class="btn btn-sm rounded-2 deleteVehicleBtn change-color1" type="button"  data-placement="top" title="Delete" value="{{$member->deliverySheet_id}}"><i class="fa fa-trash"></i></button>
                                    {{--                            </a>--}}
                                </li>

                            @endif
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


                    const allNewDivs = document.getElementsByClassName("newMessage");

                    setTimeout(function(){
                    for(let k=0; k<allNewDivs.length; k++) {
                    $(".newMessage").fadeOut();
                }
                }, 2000);


            </script>

@endsection
