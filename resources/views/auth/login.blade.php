
<!DOCTYPE html>
<html>
<head>


    <title>Login | LMDMS</title>
    <link rel="icon" href="{!! asset('images/lmdms.png') !!}"/>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link rel="stylesheet" type="text/css" href="/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">

    <script language='javascript' type='text/javascript'>
        function DisableBackButton() {
            window.history.forward()
        }
        DisableBackButton();
        window.onload = DisableBackButton;
        window.onpageshow = function(evt) { if (evt.persisted) DisableBackButton() }
        window.onunload = function() { void (0) }
    </script>


{{--    <script type="text/javascript">--}}


{{--        function preventBack() {--}}
{{--            --}}
{{--            window.history.forward(); }--}}
{{--        setTimeout('preventBack()', 0);--}}
{{--        window.onunload = function () { null };--}}
{{--    </script>--}}



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

        .change-colorAssign:hover{
            color: white;
            background-color: #0275d9;
        }
        .change-color0:hover{
            color: white;
            background-color:rgb(17, 135, 90);
        }


        .change-color:hover{
            color: white;
            background-color:rgb(11, 77, 114);
        }

        .change-color3{
            background-color: rgb(0, 73, 114);
        }
        .change-color3:hover{
            color: white;
            background-color: rgb(0, 51, 89);
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
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.3);
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

    <script src="https://kit.fontawesome.com/5c83a52b0b.js" crossorigin="anonymous"></script>

</head>
<body>



<script src="jquery-3.6.1.js" type="text/javascript"></script>
</body>
</html>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="MTqAul0oXlREZjds8YnRILI5q4Y7u0MAVKkrZQQ7">

    <title>Log in</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->


</head>
<body>
<div id="app">


    <main class="py-4 ">

        <div class="pt-5" style="" >


            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-md-6">
                        <div class="text-center" >

                            <div class="rounded-top pt-4"  style=" margin-top:3em; height: 120px; color: white;  background-color: rgb(0, 73, 114)">
                                <h2 style="font-weight: bold">Welcome to LMDMS</h2>
                                <h4 >Last Mile Delivery Management System</h4>


                            </div>

                        </div>
                        <div class="card">


                            <div class="card-header" style="font-size: 22px;">Login</div>


                            <div class="card-body">



                                <form method="POST" action="{{route('login')}}">

                                    @csrf
                                    @method('post')



                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-form-label text-md-end float-left"><i class='fa-solid fa-user-circle-o' style="font-size: 20px;"></i></label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control " name="email" value="" placeholder="Email address" onkeyup="saveValue(this)" required autocomplete="email" autofocus>
                                            @if($errors->has('email'))
                                                <p class="text-danger">{{$errors->first('email')}}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-end"><i class='fa-solid fa-lock'  style="font-size: 20px; margin-right: 2px;"></i> </label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control " name="password" placeholder="Password" onkeyup="saveValue(this)" required autocomplete="current-password">
                                            @if($errors->has('password'))
                                                <p class="text-danger">{{$errors->first('password')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Session::has('error'))
                                        <p class="text-danger text-center">{{Session::get('error')}}</p>
                                    @endif

                                    @if(Session::has('success'))
                                        <p class="text-success text-center">{{Session::get('success')}}</p>
                                    @endif

                                    <div class="row mb-2 mt-4">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn text-white change-color3" style="width: 8em; border: 1px solid  rgb(0, 73, 114);">
                                                Log in
                                            </button>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div style="display: none;" class="alert alert-success mt-3" id="logoutAlert" role="alert">
                            You're Logged Out Successfully!
                        </div>
                        <br>
                        <p style="text-align: center">For demo purpose: use admin@lmdms.com as email and admin as password, since this is a management system, therefore use desktop for a good experience. Thanks.  </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script type="text/javascript">







    @if(isset($flag))

        @if($flag)

        document.getElementById('logoutAlert').style.display = "block";
    setTimeout(function(){

            $("#logoutAlert").fadeOut();

    }, 2000);


    @endif

    sessionStorage.setItem('email', '');
    sessionStorage.setItem('password', "");
    document.getElementById("email").value = "";    // set the value to this input
    document.getElementById("password").value = "";   // set the value to this input

    @else
    document.getElementById("email").value = getSavedValue("email");    // set the value to this input
    document.getElementById("password").value = getSavedValue("password");   // set the value to this input

    @endif
   /* Here you can add more inputs to set value. if it's saved */

    //Save the value function - save it to localStorage as (ID, VALUE)
    function saveValue(e){
        var id = e.id;  // get the sender's id to save it .
        var val = e.value; // get the value.
        sessionStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
    }

    //get the saved value function - return the value of "v" from localStorage.
    function getSavedValue  (v){
        if (!sessionStorage.getItem(v)) {
            return "";// You can change this to your defualt value.
        }
        return sessionStorage.getItem(v);
    }


</script>


</body>
</html>

