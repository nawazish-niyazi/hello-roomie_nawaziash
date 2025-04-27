<?php
$servername = "localhost";
$username = "root";
$password = "enter_pass";
$dbname = "dental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$name = $_POST['name'];
$age = $_POST['age'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$sex = $_POST['sex'];
$course = $_POST['course'];
$sem = $_POST['sem'];
$Hobbies = $_POST['hobbies'];
$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];
$answer4 = $_POST['answer4'];
$answer5 = $_POST['answer5'];
$answer6 = $_POST['answer6'];
$answer7 = $_POST['answer7'];
$answer8 = $_POST['answer8'];
$answer9 = $_POST['answer9'];
$answer10 = $_POST['answer10'];
$answer11 = $_POST['answer11'];
$answer12 = $_POST['answer12'];
$answer13 = $_POST['answer13'];
$answer14 = $_POST['answer14'];
$answer15 = $_POST['answer15'];
$answer16 = $_POST['answer16'];
$answer17 = $_POST['answer17'];

// Insert data into the database
$sql = "INSERT INTO users (name, age, contact, email, sex, course, sem, hobbies, answer1, answer2, answer3, answer4, answer5, answer6, answer7, answer8, answer9, answer10, answer11, answer12, answer13, answer14, answer15, answer16, answer17 ) 
        VALUES ('$name', '$age', '$contact', '$email', '$sex', '$course', '$sem', '$Hobbies', '$answer1', '$answer2', '$answer3', '$answer4', '$answer5', '$answer6', '$answer7', '$answer8', '$answer9', '$answer10', '$answer11', '$answer12', '$answer13', '$answer14', '$answer15', '$answer16', '$answer17')";

if ($conn->query($sql) === TRUE) {
    header("Location: match.php?email=$email");  // Redirect to match.php
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
