<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user'];

// Stats
$total = $conn->query("SELECT COUNT(*) as total FROM workouts WHERE user_id=$user_id")->fetch_assoc();
$calories = $conn->query("SELECT SUM(calories) as total FROM workouts WHERE user_id=$user_id")->fetch_assoc();
$duration = $conn->query("SELECT SUM(duration) as total FROM workouts WHERE user_id=$user_id")->fetch_assoc();

// Chart Data
$data = $conn->query("SELECT date, SUM(calories) as total FROM workouts WHERE user_id=$user_id GROUP BY date");

$labels = [];
$values = [];

while($row = $data->fetch_assoc()){
    $labels[] = $row['date'];
    $values[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Workout Dashboard</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Your CSS -->
    <link rel="stylesheet" href="assets/css/dash.css">

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container">
        <a class="navbar-brand">Workout Tracker 💪</a>

        <div class="navbar-actions">
            <a href="add-workout.php" class="nav-btn nav-btn-primary">
                ➕ Add Workout
            </a>
            <a href="auth/logout.php" class="nav-btn nav-btn-outline">
                Logout
            </a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <div class="container text-center text-white">
        <h1>Dashboard 🚀</h1>
        <p>Your fitness analytics</p>
    </div>
</section>

<div class="dashboard-container">

    <!-- STATS -->
    <div class="funnel-overview">

        <div class="stage-card lead">
            <div class="stage-name">Workouts</div>
            <div class="stage-count"><?php echo $total['total'] ?? 0; ?></div>
        </div>

        <div class="stage-card prospect">
            <div class="stage-name">Calories</div>
            <div class="stage-count"><?php echo $calories['total'] ?? 0; ?></div>
        </div>

        <div class="stage-card qualified">
            <div class="stage-name">Duration</div>
            <div class="stage-count"><?php echo $duration['total'] ?? 0; ?> min</div>
        </div>

    </div>

    <!-- CHART -->
    <div class="main-funnel-container">
        <h2>Calories Progress 📊</h2>
        <canvas id="chart"></canvas>
    </div>

    <!-- RECENT WORKOUTS -->
    <div class="leads-table">
        <h3>Recent Workouts</h3>

        <?php
        $recent = $conn->query("SELECT * FROM workouts WHERE user_id=$user_id ORDER BY date DESC");

        while($row = $recent->fetch_assoc()){
        ?>
            <div class="workout-row">
    
    <div class="workout-info">
        <strong><?php echo $row['activity_type']; ?></strong><br>
        🔥 <?php echo $row['calories']; ?> cal |
        ⏱ <?php echo $row['duration']; ?> min <br>
        📅 <?php echo $row['date']; ?>
    </div>

    <div class="workout-actions">
        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏️</a>

        <a href="delete.php?id=<?php echo $row['id']; ?>" 
           onclick="return confirm('Delete?')" 
           class="btn-delete">🗑️</a>

        <?php if($row['status'] != 'completed'){ ?>
            <a href="complete.php?id=<?php echo $row['id']; ?>" class="btn-complete">✔</a>
        <?php } ?>
        <?php if($row['status'] == 'completed'){ ?>
    <span style="color:#148514;">✔ Done</span>
<?php } ?>
    </div>

</div>
        <?php } ?>

    </div>

</div>

<script>
new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Calories',
            data: <?php echo json_encode($values); ?>,
            borderWidth: 2
        }]
    }
});
</script>

<script src="assets/js/main.js"></script>
</body>
</html>