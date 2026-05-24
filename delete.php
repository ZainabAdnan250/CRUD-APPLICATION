<?php
session_start();
include 'db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION['flash'] = ['type' => 'danger', 'msg' => 'User deleted successfully.'];

header("Location: index.php");
exit();
?>
