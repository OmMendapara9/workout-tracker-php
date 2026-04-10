<?php
session_start();
include("config/db.php");

$id = $_GET['id'];

// Fetch existing data
$data = $conn->query("SELECT * FROM workouts WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){
    $activity = $_POST['activity'];
    $duration = $_POST['duration'];
    $calories = $_POST['calories'];

    $conn->query("UPDATE workouts 
        SET activity_type='$activity', duration='$duration', calories='$calories' 
        WHERE id=$id");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Workout</title>
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
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Edit Workout ✏️</h2>

    <form method="POST">
        <select name="activity" required>
            <option <?php if($data['activity_type']=="Running") echo "selected"; ?>>Running</option>
            <option <?php if($data['activity_type']=="Gym") echo "selected"; ?>>Gym</option>
            <option <?php if($data['activity_type']=="Cycling") echo "selected"; ?>>Cycling</option>
            <option <?php if($data['activity_type']=="Walking") echo "selected"; ?>>Walking</option>
        </select>

        <input type="number" name="duration" value="<?php echo $data['duration']; ?>" required>
        <input type="number" name="calories" value="<?php echo $data['calories']; ?>" required>

        <button name="update">Update</button>
    </form>
</div>


<script>
const activity = document.querySelector("select[name='activity']");
const duration = document.querySelector("input[name='duration']");
const calories = document.querySelector("input[name='calories']");

function calc(){
    let rate = 0;

    if(activity.value == "Running") rate = 10;
    if(activity.value == "Gym") rate = 8;
    if(activity.value == "Cycling") rate = 7;
    if(activity.value == "Walking") rate = 5;

    calories.value = duration.value * rate;
}

activity.addEventListener("change", calc);
duration.addEventListener("input", calc);
</script>
</body>
</html>