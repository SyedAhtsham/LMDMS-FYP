@extends('frontend.layouts.main')
@section('main-container')


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


    <div class="container pt-5">
    </div>
    <div class="main">

        <div>
            <div class="float-left">
                <h4 class=" float-left"> {{$staff->name}}</label></h4>
            </div>
        <div class="form-group float-right mr-5 mb-3 d-flex">

            <a href="{{route('staff.edit', ['id'=>$staff->staff_id])}}">
            <button type="button" class="btn text-white mr-3" style="background-color:rgb(11, 77, 114);"><i class="fa-solid fa-user-edit mr-1"></i> Edit</button>
            </a>
                <button type="button" class="btn btn-danger text-white deleteStaffBtn" value="{{$staff->staff_id}}"><i class="fa-solid fa-trash mr-1"></i> Delete</button>
        </div>
        </div>
        <br>
<hr>


        <div class="container bootstrap snippets bootdey mt-4">
            <div class="panel-body inf-content">
                <div class="row">

                    <div class="col-md-10 ml-3 mt-2">


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
                                            <i class="fa-solid fa-clipboard-user mr-1"></i> Staff Code
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        <br> {{$staff->staffCode}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-user  text-primary"></span>
                                            <i class="fa-solid fa-user  mr-1"></i> Name
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-cloud text-primary"></span>
                                            <i class="fa-solid fa-at  mr-1"></i> Email
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->email}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                            <i class="fa-solid fa-phone mr-1"></i> Contact
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->contact}}
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-eye-open text-primary"></span>
                                            <i class="fa-solid fa-location-dot  mr-1"></i> Address
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->address}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-envelope text-primary"></span>
                                            <i class="fa-solid fa-id-card  mr-1"></i> CNIC
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->cnic}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            <i class="fa-solid fa-briefcase  mr-1"></i>  Position
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->position}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            <i class="fa-solid fa-venus-mars  mr-1"></i> Gender
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->gender}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                            <i class="fa-regular fa-calendar  mr-1"></i> Date of Birth
                                        </strong>
                                    </td>
                                    <td class="text-primary">
                                        {{$staff->dob}}
                                    </td>
                                </tr>


                @if(isset($driver))

                    <tr><td><br></td></tr>
                    <tr>
                        <td>  <strong style="font-size: 20px;">Additional Information</strong> </td>
                    </tr>


                                    <tr>
                                        <td>
                                            <strong>
                                                <br> <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                <i class="fa-regular fa-id-card  mr-1"></i>  License No
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            <br> {{$driver->licenseNo}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-user  text-primary"></span>
                                                <i class="fa-solid fa-star  mr-1"></i> Experience
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{$driver->yearsExp}} years
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-cloud text-primary"></span>
                                                <i class="fa-solid fa-car  mr-1"></i> Can Drive
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{$driver->canDrive}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                                <i class="fa-solid fa-check  mr-1"></i> Status
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{$driver->status}}
                                        </td>
                                    </tr>
                @endif

                    <tr><td><br></td></tr>
                    <tr>
                        <td>  <strong style="font-size: 20px;">User Account</strong> </td>
                    </tr>


                    <tr>
                        <td>
                            <strong>
                                <br> <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                <i class="fa-solid fa-user-circle  mr-1"></i> Email
                            </strong>
                        </td>
                        <td class="text-primary">
                            <br> {{$account->email}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-user  text-primary"></span>
                                <i class="fa-solid fa-lock  mr-1"></i> Password
                            </strong>
                        </td>
                        <td class="text-primary">

                            <div class="form-group d-flex">
                                <div>
                                    <input type="password" disabled class="form-control" value="{{$account->password}}" id="myInput">


<input type="hidden" value="{{$staff->staff_id}}" required min="4" name="staffID" id="staffID">
                                    <input type="checkbox" class="form-check-input ml-1 mt-2" onclick="myFunction()"><label class="ml-4 mt-1 text-black" >Show Password</label>

                                </div>
                            <div class="mt-1 ml-2" id="editBtn001Div">

                                <button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit()" id="editBtn001" type="button"
                                        data-toggle="" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>



                            </div>
                            </div>
                        </td>
                    </tr>

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
            password.disabled = 'disabled';
            editDiv.innerHTML = '';
            editDiv.innerHTML = '<button class="btn btn-sm rounded-0 change-color rounded-2" onclick="edit()" id="editBtn001" type="button" data-toggle="" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';

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

    </script>

@endsection
