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

// Ensure 'email' is passed in the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Prepare and execute query to fetch the current user's answers
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $currentUserResult = $stmt->get_result();
    
    // Check if the user exists
    if ($currentUserResult->num_rows > 0) {
        $currentUser = $currentUserResult->fetch_assoc();

        // Get the current user's answers
        $answers = [
            $currentUser['answer1'], $currentUser['answer2'], $currentUser['answer3'],
            $currentUser['answer4'], $currentUser['answer5'], $currentUser['answer6'],
            $currentUser['answer7'], $currentUser['answer8'], $currentUser['answer9'],
            $currentUser['answer10'], $currentUser['answer11'], $currentUser['answer12'],
            $currentUser['answer13'], $currentUser['answer14'], $currentUser['answer15'],
            $currentUser['answer16'], $currentUser['answer17']
        ];

        // Fetch other users' data
        $stmt = $conn->prepare("SELECT * FROM users WHERE email != ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Array to store matches with compatibility over 60%
        $matches = [];

        // Compare the current user's answers with other users
        while ($row = $result->fetch_assoc()) {
            $score = 0;
            for ($i = 1; $i <= 17; $i++) {
                if ($answers[$i - 1] == $row["answer$i"]) {
                    $score++;
                }
            }

            // Calculate compatibility percentage
            $percentage = ($score / 17) * 100;

 //new line 
         $percentage = number_format($percentage, 2);
         
            // If the compatibility is greater than 60%, store the match
            if ($percentage >= 60) {
                $matches[] = [
                    'name' => $row['name'],
                    'age' => $row['age'],
                    'contact' => $row['contact'],
                    'course' => $row['course'],
                    'sem' => $row['sem'],
                    'hobbies' => $row['hobbies'],
                    'sex' => $row['sex'],
                    'compatibility' => $percentage
                ];
            }
        }

        // Sort the matches array by compatibility score in descending order
        usort($matches, function ($a, $b) {
            return $b['compatibility'] - $a['compatibility']; // Sort in descending order
        });

    } else {
        echo "No user found with the provided email.";
        exit;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Email not provided.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Matches</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h1 {
            font-size: 3.5rem;
            color: #4CAF50;
            text-align: center;
            margin-bottom: 10px;
            font-family: "Charm", serif;
        }

        .match {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }

        .match p {
            margin: 10px 0;
        }

        .match strong {
            font-weight: bold;
        }

        .match .compatibility {
            color: #4CAF50;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <h1>Best Matches for You!</h1>

    <?php if (!empty($matches)) { ?>
        <?php foreach ($matches as $match) { ?>
            <div class="match">
                <p><strong>Name:</strong> <?= $match['name'] ?></p>
                <p><strong>Age:</strong> <?= $match['age'] ?></p>
                <p><strong>Contact:</strong> <?= $match['contact'] ?></p>
                <p><strong>Course:</strong> <?= $match['course'] ?></p>
                <p><strong>Sem:</strong> <?= $match['sem'] ?></p>
                <p><strong>Hobbies:</strong> <?= $match['hobbies'] ?></p>
                <p><strong>Sex:</strong> <?= $match['sex'] ?></p>
                <p class="compatibility"><strong>Compatibility:</strong> <?= $match['compatibility'] ?>%</p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No matches found with 60% or more compatibility.</p>
    <?php } ?>

</body>

</html>
