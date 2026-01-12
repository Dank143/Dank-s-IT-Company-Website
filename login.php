<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
  <title>Login - Dank's IT Company</title>
</head>
<body>
    <?php
        $activePage = "login";
        $pageTitle = "My Manager Login";   
        include 'header.inc'; 
        include 'menu.inc';
    ?> 

    <main class="manage">
        <?php
            session_start();

            // Check if the user is already logged in, redirect to manage page if yes.
            if (isset($_SESSION['user_id'])) {
                header("Location: manage.php");
                exit();
            }

            // Check if the login form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Set username and password here
                $username = '1';
                $password = '2';

                // Check if the login is locked
                if (isset($_SESSION['login_lockout_time']) && $_SESSION['login_lockout_time'] > time()) {
                    $remainingTime = $_SESSION['login_lockout_time'] - time();
                    $error = "Account is temporarily locked. Please try again in " . $remainingTime . " seconds.";
                } else {
                    if ($_POST['username'] === $username && $_POST['password'] === $password) {
                        // Reset login attempts on successful login
                        unset($_SESSION['login_attempts']);
                        // Set a session variable to indicate the user is logged in.
                        $_SESSION['user_id'] = 1;
                        header("Location: manage.php");
                        exit();
                    } else {
                        // Increment login attempts
                        if (!isset($_SESSION['login_attempts'])) {
                            $_SESSION['login_attempts'] = 1;
                        } else {
                            $_SESSION['login_attempts']++;
                        }
                        
                        // Check if login attempts exceed a threshold 
                        if ($_SESSION['login_attempts'] >= 5) {
                            // Lock the login form for a certain time 
                            $_SESSION['login_lockout_time'] = time() + 15;
                            unset($_SESSION['login_attempts']);
                            $error = "Account is temporarily locked. Please try again in 15 seconds.";
                        } else {
                            $error = "Invalid username or password.";
                        }
                    }
                }
            }
        ?>

        <h2>Manager Login</h2>
        <?php if (isset($error)): ?>
            <p class="fail-message"><?= $error; ?></p>
        <?php endif; ?>
        <form action="login.php" class="login" method="post">
            <label for="username">Username:</label>
            <input type="username" id="username" name="username" required>
            <div class="form-space"></div>
            <label for="password" class="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login" class="login-button">Login</button>
        </form>
    </main>
    
    <?php include "footer.inc"; ?>
</body>
</html>
