<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user'];

if(isset($_POST['add'])){
    $activity = $_POST['activity'];
    $duration = $_POST['duration'];
    $calories = $_POST['calories'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO workouts (user_id, activity_type, duration, calories, date)
            VALUES ('$user_id', '$activity', '$duration', '$calories', '$date')";

    if($conn->query($sql)){
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Workout</title>
    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: #1e293b;
            padding: 30px;
            border-radius: 15px;
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(45deg, #6a5af9, #a855f7);
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Add Workout 💪</h2>

    <form method="POST">
        <select name="activity" required>
            <option value="">Select Activity</option>
            <option>Running</option>
            <option>Gym</option>
            <option>Cycling</option>
            <option>Walking</option>
        </select>

        <input type="number" id="duration" name="duration" placeholder="Duration (min)" required>
        <input type="number" id="calories" name="calories" placeholder="Calories" readonly>

        <button name="add">Add Workout</button>
    </form>

    <a href="dashboard.php">← Back to Dashboard</a>
</div>

<script>
const activity = document.querySelector("select[name='activity']");
const duration = document.getElementById("duration");
const calories = document.getElementById("calories");

function calculateCalories(){
    let rate = 0;

    if(activity.value == "Running") rate = 10;
    if(activity.value == "Gym") rate = 8;
    if(activity.value == "Cycling") rate = 7;
    if(activity.value == "Walking") rate = 5;

    calories.value = duration.value * rate;
}

activity.addEventListener("change", calculateCalories);
duration.addEventListener("input", calculateCalories);
</script>

</body>
</html>