<?php
session_start();
include 'db.php';

// Grab flash message if exists
$flash = null;
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

$result = $conn->query("SELECT * FROM users");
$totalUsers = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1">⚙️ User Management System</span>
        <a href="create.php" class="btn btn-success btn-sm px-3">+ Add User</a>
    </div>
</nav>

<div class="container mt-4">

    <!-- Flash Message -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show flash-alert" role="alert">
            <?php if ($flash['type'] === 'success'): ?>✅<?php elseif ($flash['type'] === 'danger'): ?>🗑️<?php else: ?>✏️<?php endif; ?>
            <strong><?= htmlspecialchars($flash['msg']) ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Bar -->
    <div class="stats-bar mb-4">
        <span class="stats-label">Total Users</span>
        <span class="stats-count"><?= $totalUsers ?></span>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
            if ($totalUsers > 0) {
                $result->data_seek(0);
                while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td class="text-muted"><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="<?= $row['id'] ?>"
                            data-name="<?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6' class='text-center text-muted py-4'>No users found. <a href='create.php'>Add one?</a></td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">⚠️ Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="fs-5 mb-1">Are you sure you want to delete</p>
                <p class="fw-bold fs-5" id="modalUserName"></p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('modalUserName').textContent = button.getAttribute('data-name');
        document.getElementById('confirmDeleteBtn').href = 'delete.php?id=' + button.getAttribute('data-id');
    });

    // Auto-dismiss flash after 4 seconds
    const flashAlert = document.querySelector('.flash-alert');
    if (flashAlert) {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(flashAlert);
            bsAlert.close();
        }, 4000);
    }
</script>

</body>
</html>
