<?php
session_start();
include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];

// Secure input to prevent SQL Injection
$mobile = mysqli_real_escape_string($connect, $mobile);
$password = mysqli_real_escape_string($connect, $password);

$sql = "SELECT * FROM user WHERE mobile = '$mobile' AND password = '$password'";
$data = mysqli_query($connect, $sql);

if (mysqli_num_rows($data) > 0) {
    $data_result = mysqli_fetch_array($data);

    // Fetch total counts only for admin users
    if ($data_result['register_as'] == 'Admin') {
        $query1 = "SELECT COUNT(*) AS total_users FROM user WHERE register_as = 'User'";
        $query2 = "SELECT COUNT(*) AS total_orders FROM orders";
        $query3 = "SELECT COUNT(*) AS total_crops FROM crops";
        $query4 = "SELECT COUNT(*) AS total_fertilizers FROM fertilizers"; 

        $result1 = mysqli_query($connect, $query1);
        $result2 = mysqli_query($connect, $query2);
        $result3 = mysqli_query($connect, $query3);
        $result4 = mysqli_query($connect, $query4);

        $row1 = mysqli_fetch_assoc($result1);
        $row2 = mysqli_fetch_assoc($result2);
        $row3 = mysqli_fetch_assoc($result3);
        $row4 = mysqli_fetch_assoc($result4);

        $_SESSION['total_users'] = $row1['total_users'];
        $_SESSION['total_orders'] = $row2['total_orders'];
        $_SESSION['total_crops'] = $row3['total_crops'];
        $_SESSION['total_fertilizers'] = $row4['total_fertilizers']; // ✅ Fixed this line
    }

    // Store user data in session
    $_SESSION['userdata'] = $data_result;

    // Redirect based on role
    if ($data_result['register_as'] == 'Admin') {
        echo '
        <script>
            alert("Login Successful! Redirecting to Dashboard.");
            window.location="../pages/dashboard.php?page=dashboard";
        </script>';
    } else {
        echo '
        <script>
            alert("Login Successful! Redirecting to Profile.");
            window.location="../pages/dashboard.php?page=profile";
        </script>';
    }
} else {
    echo '
    <script>
        alert("Invalid mobile number or password!");
        window.location="../";
    </script>';
}
?>
