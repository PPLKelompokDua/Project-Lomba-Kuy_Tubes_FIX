<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    
    $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: Task Management.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>