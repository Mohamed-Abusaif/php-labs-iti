<?php
$firstName = $_POST["firstName"] ?? "";
$lastName = $_POST["lastName"] ?? "";
$address = $_POST["address"] ?? "";
$skills = $_POST["skills"] ?? [];
$gender = $_POST["gender"] ?? "";
$userName = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";
$department = $_POST["department"] ?? "";
$code = $_POST["code"] ?? "";

if ($code !== "FSD578A") {
    header("Location: form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">Submitted Data</h4>
                <div class="list-group">
                    <p class="list-group-item">
                        Thank You <?php echo ($gender === "Female") ? "Ms." : "Mr."; ?>
                        <?php echo $firstName . ' ' . $lastName; ?>, here is your data:
                    </p>
                    <p class="list-group-item"><strong>First Name:</strong> <?php echo $firstName; ?></p>
                    <p class="list-group-item"><strong>Last Name:</strong> <?php echo $lastName; ?></p>
                    <p class="list-group-item"><strong>Address:</strong> <?php echo $address; ?></p>
                    <p class="list-group-item"><strong>Skills:</strong>
                        <?php
                        if (!empty($skills)) {
                            foreach ($skills as $skill) {
                                echo '<span class="badge bg-primary me-1">' . $skill . '</span> ';
                            }
                        } else {
                            echo '<span class="text-muted">No skills selected.</span>';
                        }
                        ?>
                    </p>
                    <p class="list-group-item"><strong>Gender:</strong> <?php echo $gender; ?></p>
                    <p class="list-group-item"><strong>Username:</strong> <?php echo $userName; ?></p>
                    <p class="list-group-item"><strong>Password:</strong> <?php echo $password; ?></p>
                    <p class="list-group-item"><strong>Department:</strong> <?php echo $department; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>