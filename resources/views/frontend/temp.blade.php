<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<h4>All Staff</h4>
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
                <button type="button" style="width: 8em;  background-color: rgb(0, 74, 111);"
                        class="btn btn-primary">Reset
                </button>
            </a>
        </div>
    </form>

</div>
<table  class="table table-sm table-striped" >
    <thead class="" style="color:white; background-color: rgb(0, 73, 114);">
    <tr>
        <th>#</th>
        <th>Staff ID</th>
        <th>Name</th>
        {{--            <th>Email</th>--}}
        <th>Contact</th>
        {{--            <th>CNIC</th>--}}
        <th>Address</th>
        {{--            <th>DOB</th>--}}
        <th>Position</th>
        <th>Gender</th>
        <th>License No.</th>
        {{--            <th>Years Experience</th>--}}
        <th>Can Drive</th>

    </tr>
    </thead>

    <tbody>
    <tr>
    @php
        $i = 1;
        $size = sizeof($staff);
    @endphp
    @if($size<=0)

</table>
<center><i> Sorry, no record found! </i></center>
@else
    @foreach($staff as $member)
        <td>{{$i++}}</td>
        <td>{{$member->staffCode}}</td>
        <td>{{$member->name}}</td>
        {{--            <td>{{$member->email}}</td>--}}
        <td>{{$member->contact}}</td>
        {{--            <td>{{$member->cnic}}</td>--}}
        <td>{{$member->address}}</td>
        {{--            <td>{{$member->dob}}</td>--}}
        <td>{{$member->position}}</td>
        <td>
            @if($member->gender == 'M')
                Male
            @elseif($member->gender == 'F')
                Female
            @else
                Other


        @endif
        @if($member->position == "Driver")

            <td>{{$member->licenseNo}}</td>
            {{--                <td>{{$member['getDriver']['yearsExp']}}</td>--}}
            <td>{{$member->canDrive}}</td>


        @else
            <td>---</td>
            {{--                    <td>---</td>--}}
            <td>---</td>

            @endif

            </tr>
            @endforeach

            @endif
            </tbody>

            </table>
            <div class="row pagination-sm">
                {{$staff->links()}}
            </div>


</body>
</html>
