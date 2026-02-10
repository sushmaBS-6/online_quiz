<?php
include("db.php");
session_start();

if(!isset($_SESSION['username'])){
    echo "Please login first! <a href='login.php'>Login</a>";
    exit();
}

$score = 0;

$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);

echo "<h2>Quiz Result</h2>";
echo "Hello, ".$_SESSION['username']."!<br><br>";

while($row = mysqli_fetch_assoc($result)){
    $qid = $row['id'];
    $correct = $row['correct_answer'];

    // Map correct answer letter to actual text
    $correct_text = "";
    if($correct == "A") $correct_text = $row['option_a'];
    if($correct == "B") $correct_text = $row['option_b'];
    if($correct == "C") $correct_text = $row['option_c'];
    if($correct == "D") $correct_text = $row['option_d'];

    echo "<p><b>Q: ".$row['question']."</b></p>";

    if(isset($_POST['answer'.$qid])){
        $user_answer = $_POST['answer'.$qid];

        // Map user answer letter to actual text
        $user_text = "";
        if($user_answer == "A") $user_text = $row['option_a'];
        if($user_answer == "B") $user_text = $row['option_b'];
        if($user_answer == "C") $user_text = $row['option_c'];
        if($user_answer == "D") $user_text = $row['option_d'];

        if($user_answer == $correct){
            // Only show correct confirmation
            echo "✅ Your answer: ".$user_text." (Correct)<br><br>";
            $score++;
        } else {
            // Show wrong answer + reveal correct one
            echo "❌ Your answer: ".$user_text." (Wrong)<br>";
            echo "✔ Correct answer: ".$correct_text."<br><br>";
        }
    } else {
        // If skipped, show correct answer
        echo "⚠ You did not answer this question.<br>";
        echo "✔ Correct answer: ".$correct_text."<br><br>";
    }
}

echo "<h3>Your total score is: ".$score."</h3>";
?>
