<?php
    include("connect.php");
    $name=$_POST['name'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $address=$_POST['address'];
    $register_as='User';

    if($password==$cpassword){
         $insert=mysqli_query($connect,"INSERT INTO user (name, mobile,password,address,register_as) 
         VALUES('$name','$mobile','$password','$address','$register_as')");
         if($insert){
           echo '
             <script>
                 alert("Registration Successfull!");
                 window.location="../index.html";
            </script>
                ';
         }
         else{
             echo '
             <script>
                 alert("Some error occured!");
                 window.location="/pages/register.html";
             </script>
                ';
        }
    }
    else{
        echo '
             <script>
                 alert("Password and Confirm password does not match!");
                 window.location="../pages/register.html";
             </script>
             ';
         }
?>