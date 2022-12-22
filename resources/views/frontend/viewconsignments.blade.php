@extends('frontend.layouts.main')
@section('main-container')



    <div class="main pt-5" style="margin-right: 2em;" >

        <h4>View Consignments</h4>
        <hr>
        <div class="row mt-2 mb-2 d-flex">
            <form action="" class="col-10 d-flex">
                <div class="form-group col-7">
                    <input type="search" name="search" id="" class="form-control" value="{{$search}}" placeholder="Search by consignment id, to-Address, from-Address, type..">
                </div>
                <div class="">
                    <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"
                            class="btn btn-primary">Search
                    </button>
                </div>

                <div class="col-2">
                    <a href="{{url('/frontend/view-consignments')}}">
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
                <th>CN #</th>
                <th style="width: 17em;" class="pl-1">From</th>
                {{--            <th>Email</th>--}}
                <th style="width: 17em; padding-left: 2em;" >To</th>
                {{--            <th>CNIC</th>--}}
                <th style="padding-left: 3em;">Weight</th>
                {{--            <th>DOB</th>--}}
                <th>Volume</th>
                <th>COD</th>
                <th>Type</th>
                {{--            <th>Years Experience</th>--}}

            </tr>
            </thead>

            <tbody>
            <tr>
                @php
                    $i = 0;
                    $size = sizeof($consignment);

                @endphp
                @if($size<=0)
            </tr>
        </table>

        <center><i> Sorry, no record found! </i></center>
        @else
            @foreach($consignment as $member)



                <td>
                    <div class="d-inline-flex">
                        <div>
                 {{++$i}}
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


                <td >{{$member->consCode}}</td>
                <td class="pl-1">{{$member->fromAddress." (".$member->fromContact.")"}}</td>
                {{--            <td>{{$member->email}}</td>--}}
                <td style="padding-left: 2em;">{{$member->toAddress." (".$member->toContact.")"}}</td>
                {{--            <td>{{$member->cnic}}</td>--}}
                <td style="padding-left: 3em;">{{$member->consWeight}}</td>
                {{--                        <td>{{$member->getDob($member->dob)}}</td>--}}
                <td>
                    {{$member->consVolume}}<sup>3</sup>
                </td>

                <td>{{$member->COD ?? "----"}}</td>

                <td>{{$member->consType}}</td>



{{--                <td>--}}
{{--                    <!-- Call to action buttons -->--}}

{{--                    <ul class="list-inline m-0">--}}

{{--                        --}}{{--                    <li class="list-inline-item">--}}
{{--                        --}}{{--                       <a href="{{url('/frontend/edit-staff/{id}')}}">--}}
{{--                        --}}{{--                        <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
{{--                        --}}{{--                       </a>--}}
{{--                        --}}{{--                    </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <a href="{{route('staff.edit', ['id'=>$member->cons_id])}}">--}}
{{--                                <button class="btn btn-success btn-sm rounded-0" style="background-color: rgb(11, 77, 114);" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        --}}{{--                    <li class="list-inline-item">--}}
{{--                        --}}{{--                        <a href="{{url('/frontend/delete-staff/'.$member->staff_id)}}">--}}
{{--                        --}}{{--                        <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
{{--                        --}}{{--                        </a>--}}
{{--                        --}}{{--                    </li>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <a href="{{route('staff.delete', ['id'=>$member->cons_id])}}">--}}
{{--                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </td>--}}
                </tr>
                @endforeach

                @endif
                </tbody>

                </table>

                <div class="row pt-2" >
                    {{$consignment->links()}}
                </div>


    </div>


@endsection
