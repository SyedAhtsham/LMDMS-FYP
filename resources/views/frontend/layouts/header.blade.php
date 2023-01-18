
<!DOCTYPE html>
<html>
<head>


    <title>@yield('title')LMDMS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{--    <link rel="stylesheet" type="text/css" href="/css/m.css">--}}

<link rel="stylesheet" type="text/css" href="/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">



    @if((!Session::get('staff_id')))

        <script>
            window.location.href = "{{ route('login')}}";
        </script>

    @endif

{{--    <link rel="stylesheet" type="text/css" href="/css/m.css">--}}

{{--    --}}
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/58bf3a6361.js" crossorigin="anonymous"></script>

    <style>

        body {
            font-family: "Lato", sans-serif;
/*background-color: rgba(53, 54, 58, 1);*/
/*            color: white;*/
        }

        .required{
            color: red;

        }
        .swal2-confirm { display:none !important;  }

       /*.swal2-styled*/
       /* {*/
       /*     background-color: black;*/
       /* }*/
       /* .swal2-confirm*/
       /* {*/
       /*     background-color: black;*/
       /* }*/

        /* Fixed sidenav, full height */
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(0, 73, 114);
            /*background-color: #1e2125;*/
            overflow-x: hidden;
            padding-top: 20px;
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Style the sidenav links and the dropdown button */
        .sidenav a, .dropdown-btn {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 16px;
            color: #F5F5F5;
            display: block;
            border: none;
            padding: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        #userLabel{
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 16px;
            color: #F5F5F5;
            display: block;
            border: none;
            padding: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: none;
            width: 100%;
            text-align: left;

            outline: none;

        }
        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
            color: white;
            font-weight: 700;
            background: rgb(0, 51, 89);
        }

        /* Main content */
        .main {
            margin-left: 18em; /* Same as the width of the sidenav */
            /*font-size: 20px;*/ /* Increased text to enable scrolling */
            padding: 0px 10px;

        }

        /* Add an active class to the active dropdown button */
        .active {
            background-color: rgb(0, 51, 89);
            color: white;

        }

        .padding-table-columns td
        {
            padding:0 5px 0 0; /* Only right padding*/
        }


        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
            display: none;
            background-color: rgb(11, 77, 114);
            padding-left: 10px;

        }
        .change-color0:hover{
            color: white;
            background-color:rgb(17, 135, 90);
        }


        #assignVehBtnColor:hover{

            color: white;
            background-color:#0275d9;
        }

        .change-color:hover{
            color: white;
            background-color:rgb(11, 77, 114);
        }

        .change-color1:hover{
            color: white;
            background-color:RGB(222, 52, 72);
        }

        .active-btn{
            background-color:rgb(11, 77, 114);
            color: white;
        }
        /* Optional: Style the caret down icon */
        .fa-caret-down {
            float: right;
            padding-right: 8px;

        }

        #addConsignmentShort{
            display: none;
        }

        #checkoutShort{
            display: none;
        }

        #checkedOutShort{
            display: none;

        }

        .inf-content{
            border:1px solid #DDDDDD;
            -webkit-border-radius:10px;
            -moz-border-radius:10px;
            border-radius:10px;
            box-shadow: 7px 7px 7px rgba(0, 0, 0, 0.3);
        }
        /*.nav-link{*/
        /*    font-weight: bold;*/
        /*}*/
        /* Some media queries for responsiveness */
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}


        }

        @media (max-width: 1400px) {
            #addConsignmentShort {
                display: block;
                margin-right: 0;

            }
            #addConsignmentLong{
                display: none;
            }
            #checkoutLong{
                display: none;

            }
            #checkoutShort{
                display: block;
                margin-left: 0;
            }



        }

        @media (max-width: 1400px){
            #checkedOutLong{
                display: none;

            }
            #checkedOutShort{
                display: block;
                margin-left: 0;

            }
        }

    </style>
{{--    <script src="https://kit.fontawesome.com/58bf3a6361.js" crossorigin="anonymous"></script>--}}
    <script src="https://kit.fontawesome.com/5c83a52b0b.js" crossorigin="anonymous"></script>

</head>
<body>

<div class="container">
    <div class="sidenav" >





        <a href="{{url('/')}}" ><i class="fa-solid fa-home fa-lg" style="padding-right: 14px;"></i> LMDMS</a>

        <button class="dropdown-btn" style="outline:0;" ><i class="fa-solid fa-truck fa-lg"></i>&nbsp;&nbsp;&nbsp;Vehicles
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container" >
            <a href="{{url('/frontend/add-vehicle')}}" style="font-size: 14px;"><img src="{{url('frontend\images\addcar1.png')}}" width="18em" height="17em"> &nbsp;&nbsp;Add Vehicle</a>
{{--            <i class="fa-solid fa-plus fa-lg"></i>--}}
            <a href="{{url('/frontend/view-vehicle')}}" style="font-size: 14px;"><i class="fa-solid fa-car"></i> &nbsp;&nbsp;View Vehicles</a>
            <a href="{{url('/frontend/view-vehicleAssignments')}}" style="font-size: 14px;"><i class="fa-solid fa-list"></i> &nbsp;&nbsp;Vehicle Assignments</a>
        </div>

        <button class="dropdown-btn" style="outline:0;"><i class="fa-solid fa-users fa-lg" style=" padding-right: 14px; padding-left: 0px; " ></i>Staff
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container" >
            <a href="{{url('/frontend/add-staff')}}" style="font-size: 14px;"><i class="fa-solid fa-user-plus "></i> &nbsp;&nbsp;Add Staff</a>
            <a href="{{url('/frontend/view-staff')}}" style="font-size: 14px;"><i class="fa-solid fa-users"></i> &nbsp;&nbsp;View Staff</a>
        </div>

{{--        <button class="dropdown-btn"  style="outline:0;"><i class="fa-solid fa-gas-pump fa-lg" style="padding-right: 19px; padding-left: 1px;"></i>Fuel--}}
{{--            <i class="fa fa-caret-down"></i>--}}
{{--        </button>--}}
{{--        <div class="dropdown-container">--}}
{{--            <a href="{{url('/frontend/view-fuel')}}" style="font-size: 14px;"><i class="fa-solid fa-droplet"></i> &nbsp;&nbsp;View Fuel</a>--}}
{{--            <a href="#" style="font-size: 14px;"><i class="fa-solid fa-paper-plane"></i> &nbsp;&nbsp;Request Fuel</a>--}}
{{--        </div>--}}


        <a href="{{url('/frontend/view-deliverysheets')}}"><i class="fa-solid fa-file fa-lg" style="padding-right: 17px; padding-left: 3px;"></i> Delivery Sheets</a>


        <a href="{{url('/frontend/view-consignments')}}"><i class="fa-solid fa-box-open fa-lg" style="padding-right: 10px;"></i> Consignments</a>

        <div style="height: 50px;">

        </div>

        @if(Session::get('position')=="Driver")
        <label id="userLabel"> <i class="fa-solid fa-user-nurse fa-lg pl-1" style="padding-right: 10px;"></i> Driver</label>
            @elseif(Session::get('position')=="Manager")
            <label id="userLabel"> <i class="fa-solid fa-user-circle fa-lg pl-1" style="padding-right: 10px;"></i> Manager</label>
        @elseif(Session::get('position')=="Supervisor")
            <label id="userLabel"> <i class="fa-regular fa-user-circle fa-lg pl-1" style="padding-right: 10px;"></i> Supervisor</label>
        @endif

        <button class="dropdown-btn" style="outline:0;"> <i class="fa-solid fa-user-tie fa-lg" style="padding-right: 3px; padding-left: 4px;"></i> &nbsp{{Session::get('user')}}<i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container" >
            <a href="{{route('view.singlestaff', ['id'=>Session::get('staff_id')])}}" style="font-size: 14px;"><i class="fa-solid fa-eye fa-lg"></i> &nbsp;&nbsp;View Profile</a>

            <a  href="{{route('staff.edit', ['id'=>Session::get('staff_id')])}}" style="font-size: 14px;"><i class="fas fa-user-edit fa-lg"></i> &nbsp;&nbsp;Edit Profile</a>
            <a href="{{route('logout')}}" style="font-size: 14px;"><i class="fa-solid fa-right-from-bracket fa-lg"></i> &nbsp;&nbsp;&nbsp;Log out</a>

        </div>


    </div>


</div>

@include('sweetalert::alert')

