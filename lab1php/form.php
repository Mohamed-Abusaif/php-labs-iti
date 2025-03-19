<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Register Form</h2>
        <form action="user.php" method="POST">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="First Name" required name="firstName">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Last Name" required name="lastName">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" placeholder="Address" required name="address"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Skills</label>
                <div>
                    <input type="checkbox" id="php" name="skills[]" value="PHP">
                    <label for="php">PHP</label>
                </div>
                <div>
                    <input type="checkbox" id="mysql" name="skills[]" value="MySQL">
                    <label for="mysql">MySQL</label>
                </div>
                <div>
                    <input type="checkbox" id="java" name="skills[]" value="Java">
                    <label for="java">Java</label>
                </div>
                <div>
                    <input type="checkbox" id="cpp" name="skills[]" value="C++">
                    <label for="cpp">C++</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div>
                    <input type="radio" id="male" name="gender" value="Male" required>
                    <label for="male">Male</label>
                </div>
                <div>
                    <input type="radio" id="female" name="gender" value="Female" required>
                    <label for="female">Female</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" id="username" placeholder="User Name" required name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" required name="password">
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" placeholder="Department" required name="department">
            </div>
            <div class="mb-3">
                <p>FSD578A</p>
                <label for="code" class="form-label">Please insert the code in the below box</label>
                <input type="text" class="form-control" id="code" placeholder="insert code" required name="code">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>
    </div>
</body>

</html>
