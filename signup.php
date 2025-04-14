<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up Page</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark mode background */
            color: #358faa; /* Cyan text color */
            display: flex;
            height: 100vh;
        }
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Place the video behind other content */
            object-fit: cover;
            /* Ensure the video covers the entire screen */
        }
        /* Left Side */
        .left-side {
            background-color: #1e1e1e; /* Slightly lighter than the body for contrast */
            width: 65%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        /* Right Side */
        .right-side {
            background-color: #121212; /* Matches the body background */
            width: 35%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .right-side img {
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: cover;
        }

        /* Login/Sign-Up Box */
        .login-box {
            padding: 2em;
            border-radius: 10px;
            width: 500px;
            background-color: #1e1e1e;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-top: 100px;
        }

        .login-box h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #358faa;
        }

        .login-box label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
            color: #358faa;
        }

        .login-box input[type="text"],
        .login-box input[type="email"],
        .login-box input[type="password"],
        .login-box input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #333;
            background-color: #262626;
            color: #358faa;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 1em;
        }

        .login-box input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Inverts colors for better visibility in dark mode */
        }

        .name-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .name-field {
            flex: 1;
        }

        .login-box button[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 1.1em;
            color: #121212;
            background-color: #358faa;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 15px 0;
        }

        .login-box button[type="submit"]:hover {
            opacity: 0.8;
        }

        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #358faa;
            font-size: 0.9em;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #333;
            margin: 0 10px;
        }

        .divider a {
            color: whitesmoke;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    $errorMessage = "";

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; // Default XAMPP password
    $dbname = "carrentalsystem";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $conn->real_escape_string($_POST['fname']);
        $lastName = $conn->real_escape_string($_POST['lname']);
        $birthDate = $conn->real_escape_string($_POST['birth-date']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into Customers table
        $sql = "INSERT INTO Customers (FirstName, LastName, Email, PasswordHash, RegistrationDate)
                VALUES ('$firstName', '$lastName', '$email', '$passwordHash', NOW())";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the home page upon successful signup
            header("Location: homep.html");
            exit();
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
    ?>

    <div class="left-side">
        <div class="login-box">
            <h2>Create an Account</h2>
            <?php
            if (!empty($errorMessage)) {
                echo "<p style='color: red;'>$errorMessage</p>";
            }
            ?>
            <form method="POST">
                <div class="name-container">
                    <div class="name-field">
                        <label for="fname">First Name:</label>
                        <input
                            type="text"
                            id="fname"
                            name="fname"
                            placeholder="First Name"
                            required
                        />
                    </div>

                    <div class="name-field">
                        <label for="lname">Last Name:</label>
                        <input
                            type="text"
                            id="lname"
                            name="lname"
                            placeholder="Last Name"
                            required
                        />
                    </div>
                </div>

                <label for="birth-date">Birth Date:</label>
                <input type="date" id="birth-date" name="birth-date" required />

                <label for="email">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="name@example.com"
                    required
                />

                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                />

                <button type="submit">Sign Up</button>
            </form>

            <div class="divider">
                <span>Already have an account? <a href="index.php">Log in</a></span>
            </div>
        </div>
    </div>
   <div>
    <!-- Video Background -->
    <video class="video-background" autoplay loop muted>
        <source src="photos/bmw.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
   </div>
</body>
</html>
