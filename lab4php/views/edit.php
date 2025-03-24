<?php
session_start();
require_once __DIR__ . '/../models/user_model.php';

$email = $_GET['email'] ?? null;
if (!$email) {
    header('Location: users.php');
    exit();
}
// var_dump($email);
// exit();
$user = find_user_by_email($email);

if (!$user) {
    header('Location: users.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Edit User</h2>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php
                                    foreach ($_SESSION['errors'] as $error) {
                                        echo "<li>" . htmlspecialchars($error) . "</li>";
                                    }
                                    unset($_SESSION['errors']);
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="../process.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="current_email" value="<?php echo htmlspecialchars($user['Email']); ?>">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : htmlspecialchars($user['Name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : htmlspecialchars($user['Email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="room" class="form-label">Room Number</label>
                                <input type="number" class="form-control" id="room" name="room"
                                    value="<?php echo isset($_SESSION['form_data']['room']) ? htmlspecialchars($_SESSION['form_data']['room']) : htmlspecialchars($user['Room_No']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif">
                                <small class="text-muted">Leave empty to keep current picture</small>
                                <div class="mt-2">
                                    <img src="../uploads/<?php echo htmlspecialchars($user['Profile_Picture']); ?>"
                                        alt="Current Profile Picture"
                                        class="img-thumbnail"
                                        style="max-width: 150px;">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="users.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>