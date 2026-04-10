<?php
include("config/db.php");

$id = $_GET['id'];

$conn->query("UPDATE workouts SET status='completed' WHERE id=$id");

header("Location: dashboard.php");
?>