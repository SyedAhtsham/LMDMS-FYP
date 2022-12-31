<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    function submitFormFun0() {
        document.getElementById("myForm0").submit();
    }

    function submitFormFun1() {
        document.getElementById("myForm1").submit();
    }

    function submitFormFun2() {
        document.getElementById("myForm2").submit();
    }





    $(document).ready(function(){
        $("alink1").click(function(){
            $("alink1").addClass("active");
        });
    });

    $(document).ready(function(){
        $("alink1").click(function(){
            $("alink1").addClass("active");
        });
    });

    $(document).ready(function(){
        $("alink2").click(function(){
            $("alink2").addClass("active");
        });
    });

    $(document).ready(function(){
        $("alink3").click(function(){
            $("alink3").addClass("active");
        });
    });

    $(document).ready(function(){
        $("#editBtn").click(function(){
            $("#editBtn").addClass("change-color");
        });
    });



    //     $(document).ready(function(){
    //     $("#btn1").click(function(){
    //         $("#btn1").addClass("active-btn");
    //     });
    // });
    // $(document).ready(function(){
    //     $("#btn2").click(function(){
    //         $("#btn2").addClass("active-btn");
    //     });
    // });
    // $(document).ready(function(){
    //     $("#btn3").click(function(){
    //         $("#btn3").addClass("active-btn");
    //     });
    // });



    function myFunction() {
        document.getElementById("licenseNo").disabled = true;
        document.getElementById("licenseNo1").disabled = true;
        document.getElementById("inputLicenseNo0").disabled = true;
        document.getElementById("inputYearsExperience1").disabled = true;
        document.getElementById("inputCanDrive1").disabled = true;
        document.getElementById("inputYearsExperience0").disabled = true;
        document.getElementById("inputCanDrive0").disabled = true;
        document.getElementById("inputYearsExperience2").disabled = true;
        document.getElementById("inputCanDrive2").disabled = true;
    }

    function myFunction1() {
        document.getElementById("inputLicenseNo0").disabled = false;
        document.getElementById("inputYearsExperience1").disabled = true;
        document.getElementById("inputCanDrive1").disabled = true;
        document.getElementById("inputYearsExperience0").disabled = false;
        document.getElementById("inputCanDrive0").disabled = false;
        document.getElementById("inputYearsExperience2").disabled = true;
        document.getElementById("inputCanDrive2").disabled = true;
    }




</script>
<script>

    document.getElementById("ifYes").style.display = "none";
    document.getElementById("ifYes2").style.display = "none";
    document.getElementById("licenseNo").disabled = true;
    document.getElementById("licenseNo1").disabled = true;
    document.getElementById("inputLicenseNo0").disabled = true;
    document.getElementById("inputYearsExperience").disabled = true;
    document.getElementById("inputCanDrive").disabled = true;


    document.getElementById("inputYearsExperience1").disabled = true;
    document.getElementById("inputCanDrive1").disabled = true;


    document.getElementById("inputYearsExperience2").disabled = true;
    document.getElementById("inputCanDrive2").disabled = true;


    if (("inputPosition").selected == "Driver")
    {

        document.getElementById("licenseNo").disabled = false;
        document.getElementById("inputYearsExperience").disabled = false;
        document.getElementById("inputCanDrive").disabled = false;

    }

    i = 0;
    function showForDriver(that) {

        if (that.value == "Driver") {

            document.getElementById("ifYes2").style.display = "flex";

            if(i==0) {


            document.getElementById("ifYes").style.display = "flex";
                i++;


            }
            else{

                // document.getElementById("ifYes1").style.display = "none";


                document.getElementById("ifYes2").style.display = "flex";
            }
            document.getElementById("licenseNo").disabled = false;
            document.getElementById("inputYearsExperience2").disabled = false;
            document.getElementById("inputCanDrive2").disabled = false;

            document.getElementById("inputYearsExperience").disabled = false;
            document.getElementById("inputCanDrive").disabled = false;
            document.getElementById("licenseNo1").disabled = false;
            document.getElementById("inputYearsExperience1").disabled = false;
            document.getElementById("inputCanDrive1").disabled = false;
        } else {

            document.getElementById("ifYes2").style.display = "none";
            document.getElementById("ifYes1").style.display = "none";
            document.getElementById("ifYes").style.display = "none";


            document.getElementById("licenseNo").disabled = false;
            document.getElementById("licenseNo1").disabled = true;
            document.getElementById("inputLicenseNo0").disabled = true;
            document.getElementById("inputYearsExperience").disabled = false;
            document.getElementById("inputCanDrive").disabled = false;
            document.getElementById("licenseNo1").disabled = true;
            document.getElementById("inputYearsExperience1").disabled = true;
            document.getElementById("inputCanDrive1").disabled = false;
        }
    }
</script>

<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }



</script>


{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="jquery-3.6.1.js" type="text/javascript"></script>
</body>
</html>
