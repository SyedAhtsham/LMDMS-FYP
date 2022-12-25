@extends('frontend.layouts.main')
@section('main-container')
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('staff.delete')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Delete Staff</h3>
{{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="staff_delete_id" id="staff_id"  />
                        <h5>Are you sure you want to delete this <b><i>staff member</i></b> and any related <b><i>Vehicle Assignments</i></b>?</h5>
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



    <h4>Staff</h4>
    <hr>
    <div class="row mt-2 mb-2 d-flex">
        <form action="" class="col-10 d-flex">
            <div class="form-group col-7">
        <input type="search" name="search" id="" class="form-control" value="{{$search}}" placeholder="Search by name, staff id, address, gender, position or vehicle">
            </div>
                <div class="">
                <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                        class="btn btn-primary">Search
                </button>
                </div>

            <div class="col-2">
            <a href="{{url('/frontend/view-staff')}}">
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

            <th>Sr #</th>
            <th>Staff ID</th>
            <th>Name</th>
{{--            <th>Email</th>--}}
            <th>Contact</th>
{{--            <th>CNIC</th>--}}
            <th style="width: 17em;">Address</th>
{{--            <th>DOB</th>--}}
            <th>Gender</th>
            <th>Position</th>
            <th>License No.</th>
{{--            <th>Years Experience</th>--}}
            <th>Can Drive</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            @php
            $i = 0;
            $size = sizeof($staff);

            @endphp
            @if($size<=0)
        </tr>
        </table>

    <center><i> Sorry, no record found! </i></center>
            @else
            @foreach($staff as $member)

            <td>
                <div class="d-inline-flex">
                    <div>
                        {{++$i}}
                    </div>
                    @php
                        $createdAt = strtotime(\Carbon\Carbon::parse($member->created_at));
                        $currentDate = time();

                        $diff = ($currentDate-$createdAt)/3600;

                        if($diff <= 72){

                 echo '<div class="bg-warning rounded ml-1" style="width: 2.5em; text-align: center;">
                      New
                 </div>';
                     }
                    @endphp
                </div>
            </td>

            <td>{{$member->staffCode}}</td>
            <td style="width: 10em;">{{$member->name}}</td>
{{--            <td>{{$member->email}}</td>--}}
            <td>{{$member->contact}}</td>
{{--            <td>{{$member->cnic}}</td>--}}
            <td style="width: 17em;">{{$member->address}}</td>
{{--                        <td>{{$member->getDob($member->dob)}}</td>--}}
            <td>
                {{$member->gender}}
            </td>

                <td>{{$member->position}}</td>

            @if($member->position == "Driver")


                <td>{{$member->getDriver->licenseNo ?? '---'}}</td>

{{--                <td>{{$member['getDriver']['yearsExp']}}</td>--}}
                <td style="width: 8em;">{{$member->getDriver->canDrive ?? '---'}}</td>


                @else
                <td>---</td>
{{--                    <td>---</td>--}}
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
                    <li class="list-inline-item">
                        <a href="{{route('staff.edit', ['id'=>$member->staff_id])}}">
                            <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                        </a>
                    </li>
{{--                    <li class="list-inline-item">--}}
{{--                        <a href="{{url('/frontend/delete-staff/'.$member->staff_id)}}">--}}
{{--                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="list-inline-item">
{{--                        <a href="{{route('staff.delete', ['id'=>$member->staff_id])}}">--}}
{{--                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
                            <button class="btn btn-danger btn-sm rounded-0 deleteStaffBtn" type="button" data-toggle="tooltip" data-placement="top" title="Delete" value="{{$member->staff_id}}"><i class="fa fa-trash"></i></button>
{{--                        </a>--}}
                    </li>
                </ul>
            </td>
        </tr>
        @endforeach

        @endif
        </tbody>

    </table>

         <div class="row pt-2">
             {{$staff->links()}}
         </div>


</div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
           $('.deleteStaffBtn').click(function(e){
               e.preventDefault();
           var staff_id = $(this).val();
           $('#staff_id').val(staff_id);
           $('#deleteModal').modal('show');

           });

        });
    </script>

@endsection
