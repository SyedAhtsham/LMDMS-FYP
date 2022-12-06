@extends('frontend.layouts.main')
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
                        <h5>Are you sure you want to Check-out this <b><i>Delivery Sheet</i></b>?</h5>
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
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Un-Check-out Delivery Sheet</h3>
                        {{--                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>--}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="deliverySheet_id" id="deliverySheet_idU" />
                        <h5>Are you sure you want to Un-Check-out this <b><i>Delivery Sheet</i></b>?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" style="" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes Un-Check-out</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="main pt-5" style="margin-right: 2em;" >

        <h4>Delivery Sheet # {{$deliverySheet->deliverySheetCode}}</h4>
        <hr>


        <table>

            <tr>
                <td ><b>Vehicle ID: </b></td>
                <td class="p-lg-3">{{$deliverySheet->vhCode}}</td>
                <td class="pl-5">  </td>
                <td> </td>

                <td ><b>Driver: </b></td>
                <td class="p-lg-3">{{$deliverySheet->drvName}}</td>

                <form action="">
                <td class="" style="padding-left: 9.15em;">
                    @php
                if($deliverySheet->status == 'un-checked-out'){

                    @endphp
                    <button type="submit" style="width: 8em;"
                            class="btn btn-success btnCheckout" value={{$deliverySheet->deliverySheet_id}}>Check-out
                    </button>
                    @php
                }
                else{
                    @endphp
                    <button type="submit" style="width: 8em;"
                            class="btn btn-danger btnUnCheckout" value={{$deliverySheet->deliverySheet_id}}>Un-Check-out
                    </button>
                    @php
                }

                @endphp

                </td>
                </form>
            </tr>
            <tr>
                <td><b>Date: </b></td>
                <td class="p-lg-3">{{$deliverySheet->created_at}}</td>
                <td class="pl-5"> </td>
                <td> </td>
                <td><b>Area: </b></td>
                <td  class="p-lg-3">{{$deliverySheet->arNM}}</td>
            </tr>
        </table>

        <br>

        <div class="row mt-2 mb-2 d-flex">
            <form action="" class="col-10 d-flex">
                <div class="form-group col-7">
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
            </form>

        </div>
{{--        <br>--}}
{{--        <div>--}}
{{--            <ul class="nav nav-tabs" id="myTab" role="tablist">--}}
{{--                <li class="nav-item">--}}


{{--                    <form id="myForm0" action="">--}}
{{--                        <input type="hidden" name="search" value="">--}}
{{--                        @if(isset($search) && $search!="checked-out" && $search!="un-checked-out" || $search=="")--}}
{{--                            <a class="nav-link active" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>--}}
{{--                        @else--}}
{{--                            <a class="nav-link" id="alink0" data-toggle="tab" href="" onclick="submitFormFun0()" role="tab" aria-controls="profile" aria-selected="false">All</a>--}}
{{--                        @endif--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <form id="myForm1" action="">--}}
{{--                        <input type="hidden" name="search" value="checked-out">--}}
{{--                        @if(isset($search) && $search=="checked-out")--}}
{{--                            <a class="nav-link active" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>--}}
{{--                        @else--}}
{{--                            <a class="nav-link" id="alink2" data-toggle="tab" href="" onclick="submitFormFun1()" role="tab" aria-controls="profile" aria-selected="false">Checked out</a>--}}
{{--                        @endif--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <form id="myForm2" action="">--}}
{{--                        <input type="hidden" name="search" value="un-checked-out">--}}
{{--                        @if(isset($search) && $search=="un-checked-out")--}}
{{--                            <a class="nav-link active" id="alink3" data-toggle="tab" href="" onclick="submitFormFun2()" role="tab" aria-controls="contact" aria-selected="false">Un-checked out</a>--}}
{{--                        @else--}}
{{--                            <a class="nav-link" id="alink3" data-toggle="tab" href="" onclick="submitFormFun2()" role="tab" aria-controls="contact" aria-selected="false">Un-checked out</a>--}}
{{--                        @endif--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--                <div>--}}
{{--                </div>--}}
{{--                <div class="ml-5">--}}
{{--                    <form action="" class="col-15 d-flex">--}}
{{--                        <div class="form-group col-10">--}}
{{--                            <input type="search" name="search" id="" class="form-control" value="{{($search=="checked-out" || $search=="un-checked-out") ? "" : $search}}" placeholder="Search by sheet id, driver id, vehicle id, area code..">--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <button type="submit" style="width: 8em;  background-color: rgb(0, 74, 111);"--}}
{{--                                    class="btn btn-primary">Search--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="col-2">--}}
{{--                            <a href="{{url('/frontend/view-deliverysheets')}}">--}}
{{--                                <button type="button" style="width: 8em;"--}}
{{--                                        class="btn btn-light">Reset--}}
{{--                                </button>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                </li>--}}
{{--            </ul>--}}


            <table  class="table table-sm table-striped" >
                <thead class="p-5" style="color:white; background-color: rgb(0, 73, 114);">
                <tr>

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
                        $i = 0;
                        $size = sizeof($consignments);

                    @endphp
                    @if($size<=0)
                </tr>
            </table>

            <center><i> Sorry, no record found! </i></center>
            @else
                @foreach($consignments as $member)

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

                    <td>{{$member->consVolume}}</td>
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
                                <button class="btn btn-sm rounded-0 deleteConsignmentBtn change-color1" type="button" data-toggle="tooltip" data-placement="top" title="Remove" value="{{$member->cons_id}}"><i class="fa fa-trash"></i></button>
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
        $(document).ready(function(){
            $('.btnCheckout').click(function(e){
                e.preventDefault();
                let deliverySheet_id = $(this).val();
                $('#deliverySheet_id').val(deliverySheet_id);
                $('#checkoutModal').modal('show');

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
            </script>

@endsection





