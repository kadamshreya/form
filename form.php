<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$firstname = $lastname = $email = $phone = $gender = $password = $confirm_password = "";
$firstnameErr = $lastnameErr = $emailErr = $phoneErr = $genderErr = $passwordErr = $confirm_passwordErr = "";
$successMsg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Validate first name
    if (empty($_POST["firstname"])) {
        $firstnameErr = "First name is required";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST["firstname"])) {
        $firstnameErr = "First name should contain only letters and no spaces";
        $isValid = false;
    } else {
        $firstname = test_input($_POST["firstname"]);
    }

    // Validate last name
    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last name is required";
        $isValid = false;
    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST["lastname"])) {
        $lastnameErr = "Last name should contain only letters and no spaces";
        $isValid = false;
    } else {
        $lastname = test_input($_POST["lastname"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
    } else {
        $email = test_input($_POST["email"]);
    }

    // Validate phone number
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
        $isValid = false;
    } elseif (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
        $phoneErr = "Invalid phone number format";
        $isValid = false;
    } else {
        $phone = test_input($_POST["phone"]);
    }

    // Validate gender
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $isValid = false;
    } else {
        $gender = test_input($_POST["gender"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $isValid = false;
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/", $_POST["password"])) {
        $passwordErr = "Password must be at least 6 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character";
        $isValid = false;
    } else {
        $password = test_input($_POST["password"]);
    }

    // Validate confirm password
    if (empty($_POST["confirm_password"])) {
        $confirm_passwordErr = "Confirm password is required";
        $isValid = false;
    } elseif ($_POST["password"] !== $_POST["confirm_password"]) {
        $confirm_passwordErr = "Passwords do not match";
        $isValid = false;
    } else {
        $confirm_password = test_input($_POST["confirm_password"]);
    }

    // If all inputs are valid, display success message
    if ($isValid) {
        $successMsg = "Registration successful!";
        $firstname = $lastname = $email = $phone = $gender = $password = $confirm_password = "";
        echo "<script>
                setTimeout(function() {
                    document.getElementById('successMsg').classList.add('hidden');
                }, 5000);
              </script>";
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>User Registration Form</h2>
<?php if ($successMsg): ?>
    <p id="successMsg" class="success"><?= $successMsg ?></p>
<?php endif; ?>
<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>">
    <span class="error"><?= $firstnameErr ?></span>
    <br><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>">
    <span class="error"><?= $lastnameErr ?></span>
    <br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
    <span class="error"><?= $emailErr ?></span>
    <br><br>

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>">
    <span class="error"><?= $phoneErr ?></span>
    <br><br>

    <label for="gender">Gender:</label>
    <div class="gender-options">
        <input type="radio" id="male" name="gender" value="male" <?= ($gender == 'male') ? 'checked' : '' ?>>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female" <?= ($gender == 'female') ? 'checked' : '' ?>>
        <label for="female">Female</label>
        <input type="radio" id="other" name="gender" value="other" <?= ($gender == 'other') ? 'checked' : '' ?>>
        <label for="other">Other</label>
    </div>
    <span class="error"><?= $genderErr ?></span>
    <br><br>

    <label for="password">Password:</label>
    <div class="password-container">
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>">
        <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div>
    <span class="error"><?= $passwordErr ?></span>
    <br><br>

    <label for="confirm_password">Confirm Password:</label>
    <div class="password-container">
        <input type="password" id="confirm_password" name="confirm_password" value="<?= htmlspecialchars($confirm_password) ?>">
        <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
    </div>
    <span class="error"><?= $confirm_passwordErr ?></span>
    <br><br>
    
    <input type="submit" value="Register">
</form>

<script>
function togglePassword(fieldId, icon) {
    var field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        icon.textContent = "👁️‍🗨️"; 
    } else {
        field.type = "password";
        icon.textContent = "👁️"; 
    }
}
</script>

</body>
</html>
