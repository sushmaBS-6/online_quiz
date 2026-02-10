<?php
include("db.php");
session_start();

if(!isset($_SESSION['username'])){
    echo "Please login first! <a href='login.php'>Login</a>";
    exit();
}

$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
</head>
<body>
    <h2>Welcome <?php echo $_SESSION['username']; ?>, take the quiz!</h2>
    <div id="timer" style="font-weight:bold; color:red;"></div>
    <form id="quizForm" method="post" action="result.php">
    <!-- quiz questions here -->
    <input type="submit" value="Submit Quiz">

        <?php
        $i = 1;
        while($row = mysqli_fetch_assoc($result)){
            echo "<p>".$i.". ".$row['question']."</p>";
            echo "<input type='radio' name='answer".$row['id']."' value='A'> ".$row['option_a']."<br>";
            echo "<input type='radio' name='answer".$row['id']."' value='B'> ".$row['option_b']."<br>";
            echo "<input type='radio' name='answer".$row['id']."' value='C'> ".$row['option_c']."<br>";
            echo "<input type='radio' name='answer".$row['id']."' value='D'> ".$row['option_d']."<br><br>";
            $i++;
        }
        ?>
        <input type="submit" name="submit" value="Submit Quiz">
    </form>
    <script>
    // Step 1: Set total time (in seconds)
    var timeLeft = 120; // 2 minutes

    // Step 2: Function to update timer every second
    function countdown() {
        if (timeLeft <= 0) {
            clearInterval(timer); // stop countdown
            alert("Time is up! Submitting quiz...");
            document.getElementById("quizForm").submit(); // auto-submit form
        } else {
            // Show remaining time in minutes + seconds
            document.getElementById("timer").innerHTML = 
                Math.floor(timeLeft / 60) + " min " + (timeLeft % 60) + " sec remaining";
        }
        timeLeft -= 1; // decrease time
    }

    // Step 3: Run countdown every 1000ms (1 second)
    var timer = setInterval(countdown, 1000);
</script>

</body>
</html>
