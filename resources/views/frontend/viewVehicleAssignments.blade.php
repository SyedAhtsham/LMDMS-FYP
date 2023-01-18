@extends('frontend.layouts.main')
@section('title', "Vehicle Assignments | ")
@section('main-container')


    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('vehicleAssignment.delete')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Delete Vehicle</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="vehicle_delete_id" id="vehicle_id" />
                        <h5>Are you sure you want to delete this <b>Vehicle Assignment?</b></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main pt-5" style="margin-right: 2em;" >

        <h4>Vehicle Assignments</h4>
        <hr>
        <div class="row mt-2 mb-2 d-flex">
            <form action="" class="col-10 d-flex">
                <div class="form-group col-7">
                    <input type="search" name="search" id="" class="form-control" value="{{$search}}" placeholder="Search by vehicle name, code, driver name..">
                </div>
                <div class="">
                    <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                            class="btn btn-primary">Search
                    </button>
                </div>

                <div class="col-2">
                    <a href="{{url('/frontend/view-vehicleAssignments')}}">
                        <button type="button" style="width: 8em;"
                                class="btn btn-light">Reset
                        </button>
                    </a>
                </div>
            </form>

        </div>
        <table  class="table table-sm table-striped" >
            <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
            <tr>
<th class="col-1">Sr #</th>

                <th>Vehicle</th>
                {{--            <th>Email</th>--}}
                <th>Driver</th>
                <th>Assigned Date</th>
                <th>Assigned By</th>

{{--                <th>Purchase/Contract Date</th>--}}
{{--                <th>Cost in PKR</th>--}}
{{--                --}}{{--            <th>CNIC</th>--}}
{{--                <th>Condition</th>--}}
{{--                --}}{{--            <th>DOB</th>--}}
{{--                <th>Status</th>--}}

                <th class="text-center">Action</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                @php
                    $i = 1;
                    $size = sizeof($vehicleAssignments);

                @endphp
                @if($size<=0)
            </tr>
        </table>

        <center><i> Sorry, no record found! </i></center>
        @else
            @foreach($vehicleAssignments as $member)

                <td>
                    <div class="d-inline-flex">
                        <div>
                            @php
                                $total = (($vehicleAssignments->currentPage()-1) * 20) + $i;
                                echo $total;

                                $i++;
                            @endphp
                        </div>
                        @php
                            $createdAt = strtotime(\Carbon\Carbon::parse($member->dtAss));
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
                    @if(isset($member->vhCode))
                        <a href="{{route('view.singlevehicle', ['id'=>$member->vhID])}}">
                            {{$member->vhCode}}
                        </a>
                    @else
                        ---
                    @endif



                </td>



                {{--            <td>{{$member->email}}</td>--}}

                @if(isset($member->drvID))

                    <td>
                        @if(isset($member->drvID))
                            <a href="{{route('view.singlestaff', ['id'=>$member->drvID])}}">
                                {{$member->drvName}}
                            </a>
                        @endif
                    </td>

                @else

                    <td>---</td>


                @endif


                <td>{{date("d-M-Y", strtotime($member->dtAss))}}</td>

                @if(isset($member->spvID))

                    <td>
                        @if(isset($member->spvID))
                            <a href="{{route('view.singlestaff', ['id'=>$member->spvID])}}">
                                {{$member->spvName}}
                            </a>
                        @endif
                    </td>

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
{{--                        <li class="list-inline-item">--}}
{{--                            <a href="{{route('vehicle.edit', ['id'=>$member->vhID])}}">--}}
{{--                                <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        {{--                    <li class="list-inline-item">--}}
                        {{--                        <a href="{{url('/frontend/delete-staff/'.$member->staff_id)}}">--}}
                        {{--                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                        {{--                        </a>--}}
                        {{--                    </li>--}}
                        <li class="list-inline-item">
                            {{--                            <a href="{{route('vehicle.delete', ['id'=>$member->vehicle_id])}}">--}}
                            {{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                            <button class="btn btn-sm rounded-2 deleteVehicleBtn change-color1" type="button" data-toggle="" data-placement="top" title="Delete" value="{{$member->vhID}}"><i class="fa fa-trash"></i></button>
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
                    {{$vehicleAssignments->links()}}
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
