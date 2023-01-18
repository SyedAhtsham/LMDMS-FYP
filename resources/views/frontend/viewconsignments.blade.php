@extends('frontend.layouts.main')
@section('title', "Consignments | ")
@section('main-container')



    <div class="main pt-5" style="margin-right: 2em;" >

        <h4>Consignments</h4>
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
                <th style="width: 60px;">Sr #</th>
                <th>CN Code</th>
                <th style="width: 17em;" class="pl-1">From</th>
                {{--            <th>Email</th>--}}
                <th style="width: 17em; padding-left: 2em;" >To</th>
                {{--            <th>CNIC</th>--}}
                <th style="padding-left: 3em;">Weight</th>
                {{--            <th>DOB</th>--}}
                <th>Volume</th>

                <th>DSheet</th>
                <th>Type</th>
                {{--            <th>Years Experience</th>--}}

            </tr>
            </thead>

            <tbody>
            <tr>
                @php
                    $i = 1;
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
                            @php
                                $total = (($consignment->currentPage()-1) * 20) + $i;
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

{{--                <td>{{$member->COD ?? "----"}}</td>--}}


                <td> @if(isset($member->deliverySheet_id))
                        <a href="{{route('view.deliverysheet', ['id'=>$member->deliverySheet_id])}}">
                            {{$member->deliverySheet_id}}
                        </a>

                    @else
                        ---
                    @endif

                </td>
                <td>{{$member->consType}}</td>





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


@section('scripts')

    <script>
        const allNewDivs = document.getElementsByClassName("newMessage");

        setTimeout(function(){
            for(let k=0; k<allNewDivs.length; k++) {
                $(".newMessage").fadeOut();
            }
        }, 2000);

    </script>


@endsection
