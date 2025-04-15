<?php
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $lomba = $_POST['lomba'];
    $umpan_balik = $_POST['umpan_balik'];
    $evaluasi = $_POST['evaluasi'];

    $sql = "INSERT INTO feedback (nama_peserta, lomba, umpan_balik, evaluasi)
            VALUES ('$nama', '$lomba', '$umpan_balik', '$evaluasi')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<?php
$sql = "SELECT * FROM feedback ORDER BY tanggal DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row['nama_peserta'] . " - " . $row['lomba'] . "</h3>";
    echo "<p>Umpan Balik: " . $row['umpan_balik'] . "</p>";
    echo "<p>Evaluasi: " . $row['evaluasi'] . "</p>";
    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete.php?id=" . $row['id'] . "'>Hapus</a><hr>";
}
?>

// Ambil data yang akan diedit
$id = $_GET['id'];
$sql = "SELECT * FROM feedback WHERE id=$id";
$data = $conn->query($sql)->fetch_assoc();
?>

<form method="post">
    <input type="text" name="nama" value="<?= $data['nama_peserta'] ?>">
    <input type="text" name="lomba" value="<?= $data['lomba'] ?>">
    <textarea name="umpan_balik"><?= $data['umpan_balik'] ?></textarea>
    <textarea name="evaluasi"><?= $data['evaluasi'] ?></textarea>
    <button name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $lomba = $_POST['lomba'];
    $umpan_balik = $_POST['umpan_balik'];
    $evaluasi = $_POST['evaluasi'];

    $sql = "UPDATE feedback SET
            nama_peserta='$nama',
            lomba='$lomba',
            umpan_balik='$umpan_balik',
            evaluasi='$evaluasi'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diupdate!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>