<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
</head>
<body>
    <h1>Task Manager</h1>
    <a href="add.php">+ Add Task</a>
    <br><br>
    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
        $no = 1;
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus task ini?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
