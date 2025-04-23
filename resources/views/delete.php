<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    $sql = "DELETE FROM tasks WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: Task Management.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>