<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <title>Log Out - Dank's IT Company</title>
</head>
<header>
    <h1>My Manager Logout</h1>
</header>
<body>
    <main>
        <?php
            session_start();
            
            // Check if the user is already logged out
            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php"); // Redirect to the home page
                exit();
            }

            // Check if the log-out confirmation form has been submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_logout'])) {
                // Log out the user and store the log-out status
                unset($_SESSION['user_id']); // Destroy the user's session

                // Store the log-out status in a session variable
                $_SESSION['logged_out'] = true;

                // Redirect to the home page
                header("Location: index.php");
                exit();
            }
        ?>

        <h1>Log Out Confirmation</h1>
        <p class="fail-message" >Are you sure you want to log out?</p>
        
        <form class="logout-form" action="logout.php" method="post">
            <button type="submit" name="confirm_logout">Yes</button>
            <a href="manage.php">No</a>
        </form>

    </main> 
    <?php include "footer.inc"; ?>
</body>
</html>
