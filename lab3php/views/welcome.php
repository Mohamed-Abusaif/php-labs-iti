<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h2>

                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-picture mb-3">
                                    <img src="../uploads/<?php echo htmlspecialchars($_SESSION['user']['profile_picture']); ?>"
                                        alt="Profile Picture"
                                        class="img-fluid rounded-circle"
                                        style="max-width: 200px; height: auto;">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="user-details">
                                    <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
                                    <p class="mb-2"><strong>Room:</strong> <?php echo htmlspecialchars($_SESSION['user']['room']); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="logout.php" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>