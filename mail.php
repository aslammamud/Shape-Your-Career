<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$phone = $_POST['phone'];
$company = $_POST['company'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "shapeyc";
//create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
if (mysqli_connect_error())
{
    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
else
{
    $SELECT = "SELECT email From feedback Where id = ? Limit 1";
    $INSERT = "INSERT INTO feedback (name, phone, email, company, message) values(?, ?, ?, ?, ?)";
    //Prepare statement
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;
    if ($rnum == 0)
    {
        $stmt->close();
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("sssss", $name, $phone, $email, $company, $message);
        $stmt->execute();
        echo "Email sent sucessfully!";
        header('Location: feedback.html#feedbacks');
    }
    else
    {
        echo "Email not sent! Please try again.";
    }
    $stmt->close();
    $conn->close();
}

?>
