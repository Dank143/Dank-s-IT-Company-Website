<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
  <title>Manage EOIs - Dank's IT Company</title>
</head>
<body>
    <?php 
      $activePage = "manage";
      $pageTitle = "Expressions of interest";
      include 'managerheader.inc';
      include 'managermenu.inc'; 
    ?>

    <main class="manage">
    <?php
        session_start();

        // Check if the user is not logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php"); // Redirect to the login page
            exit();
        }

        require_once("settings.php"); // Include the server settings

        // Create a database connection
        $connection = @mysqli_connect(
            $host, 
            $user, 
            $pwd, 
            $sql_db
        );

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if the EOI table exists
        $tableExistsQuery = "SHOW TABLES LIKE 'EOI'";
        $tableExistsResult = mysqli_query($connection, $tableExistsQuery);

        if (mysqli_num_rows($tableExistsResult) == 0) {
            echo '<p class="fail-message">The EOI table does not exist.</p>';
        }

        // Initialize variables
        $results = array();
        $error_message = "";
        $message = "";

        if (isset($_GET["list_all"])) {
            $query = "SELECT * FROM EOI";
            $result = mysqli_query($connection, $query);
            
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $results[] = $row;
                    }
                } else {
                    $error_message = "No EOIs found in the database.";
                }
            } else {
                $error_message = "Error: " . mysqli_error($connection);
            }
        }

        // Sort feature based on columns
        if (isset($_GET["sort_eois"])) {
            $sort_field = mysqli_real_escape_string($connection, $_GET["sort_field"]);
            $sort_order = mysqli_real_escape_string($connection, $_GET["sort_order"]);
        
            if ($sort_field === 'skills') {
                $sort_field = "CHAR_LENGTH(skills)"; // Sort by number of skills
            }
        
            if ($sort_order !== 'asc' && $sort_order !== 'desc') {
                $error_message = "Invalid sort order. Please select Ascending or Descending.";
            } else {
                $query = "SELECT * FROM EOI ORDER BY $sort_field $sort_order";
                $result = mysqli_query($connection, $query);
        
                if ($result) {
                    $results = [];
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $results[] = $row;
                        }
                    } else {
                        $error_message = "No EOIs found in the database.";
                    }
                } else {
                    $error_message = "Error: " . mysqli_error($connection);
                }
            }
        }

        if (isset($_GET["list_by_job_reference"])) {
            $job_reference = mysqli_real_escape_string($connection, $_GET["job_reference"]);

            // Define an array of allowed job references
            $allowedJobReferences = ["DA123", "PM069", "AI420"];

            if (in_array($job_reference, $allowedJobReferences)) {
                $query = "SELECT * FROM EOI WHERE job_reference = '$job_reference'";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $results[] = $row;
                        }
                    } else {
                        $error_message = "No EOIs found with job reference '$job_reference'.";
                    }
                } else {
                    $error_message = "Error: " . mysqli_error($connection);
                }
            } else {
                $error_message = "Invalid job reference. Only DA123, PM069, and AI420 are allowed.";
            }
        }

        if (isset($_GET["list_by_name"])) {
            $first_name = mysqli_real_escape_string($connection, $_GET["first_name"]);
            $last_name = mysqli_real_escape_string($connection, $_GET["last_name"]);
            
            $query = "SELECT * FROM EOI WHERE first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%'";
            $result = mysqli_query($connection, $query);
            
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $results[] = $row;
                    }
                } else {
                    $error_message = "No EOIs found with the specified applicant name.";
                }
            } else {
                $error_message = "Error: " . mysqli_error($connection);
            }
        }

        if (isset($_GET["delete_by_job_reference"])) {
            $job_reference = mysqli_real_escape_string($connection, $_GET["job_reference"]);

            // Define an array of allowed job references
            $allowedJobReferences = ["DA123", "PM069", "AI420"];

            if (in_array($job_reference, $allowedJobReferences)) {
                $query = "DELETE FROM EOI WHERE job_reference = '$job_reference'";
                if (mysqli_query($connection, $query)) {
                    $message = "EOIs with job reference '$job_reference' have been deleted.";
                } else {
                    $error_message = "Error: " . mysqli_error($connection);
                }
            } else {
                $error_message = "Invalid job reference. Only DA123, PM069, and AI420 are allowed.";
            }
        }

        if (isset($_POST["change_status"])) {
            $eoi_number = mysqli_real_escape_string($connection, $_POST["eoi_number"]);
            $new_status = mysqli_real_escape_string($connection, $_POST["new_status"]);

            // Check if the EOI with the given number exists
            $check_query = "SELECT * FROM EOI WHERE EOInumber = $eoi_number";
            $result = mysqli_query($connection, $check_query);

            if (mysqli_num_rows($result) > 0) {
                // EOI with the given number exists, proceed to update the status
                $query = "UPDATE EOI SET status = '$new_status' WHERE EOInumber = $eoi_number";
                if (mysqli_query($connection, $query)) {
                    $message = "EOI #$eoi_number status has been changed to '$new_status'.";
                } else {
                    $error_message = "Error: " . mysqli_error($connection);
                }
            } else {
                // EOI with the given number was not found
                $error_message = "EOI #$eoi_number not found.";
            }
        }
        
        // Close the Database Connection
        mysqli_close($connection);
    ?>

    <?php if ($error_message): ?>
    <p class="fail-message"><?php echo $error_message; ?></p>
    <?php elseif ($message): ?>
    <p class="pass-message"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <h2>Sort All EOIs</h2>
    <form action="manage.php" method="get">
        <label for="sort_field">Sort by:</label>
        <select id="sort_field" name="sort_field" class="equal-width">
            <option value="EOInumber">EOI Number</option>
            <option value="job_reference">Job Reference</option>
            <option value="first_name">First Name</option>
            <option value="last_name">Last Name</option>
            <option value="email">Email</option>
            <option value="skills">Number of Skills</option>           
            <option value="status">Status</option>
        </select>
        <label for="sort_order">Sort order:</label>
        <select id="sort_order" name="sort_order" class="equal-width">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <button type="submit" name="sort_eois" class="eoi-button">Sort EOIs</button>
    </form>

    <!-- List All EOIs -->
    <?php if (!empty($results)): ?>
        <div class="table-container">
        <table class="manage">
            <thead>
                <tr>
                    <th>EOI No.</th>
                    <th>Job Reference</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Skills</th>
                    <th>Other Skills</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo $row['EOInumber']; ?></td>
                        <td><?php echo $row['job_reference']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['skills']; ?></td>
                        <td><?php echo $row['other_skills']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <h2>List All EOIs</h2>
    <button type="button" onclick="window.location.href='manage.php?list_all=1'" class="all-button">List All EOIs</button>

    <!-- List EOIs by Job Reference -->
    <h2>List EOIs by Job Reference</h2>
    <form action="manage.php" method="get">
        <label for="job_reference">Job Reference:</label>
        <input type="text" id="job_reference" name="job_reference" required placeholder="e.g. DA123">
        <button type="submit" name="list_by_job_reference" class="eoi-button">List EOIs</button>
    </form>

    <!-- List EOIs by Applicant Name -->
    <h2>List EOIs by Applicant Name</h2>
    <form action="manage.php" method="get">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name">
        <button type="submit" name="list_by_name" class="eoi-button">List EOIs</button>
    </form>

    <!-- Delete EOIs by Job Reference -->
    <h2>Delete EOIs by Job Reference</h2>
    <form action="manage.php" method="get">
        <label for="job_reference">Job Reference:</label>
        <input type="text" id="job_reference" name="job_reference" required placeholder="e.g. DA123">
        <button type="submit" name="delete_by_job_reference" class="eoi-button">Delete EOIs</button>
    </form>

    <!-- Change EOI Status -->
    <h2>Change EOI Status</h2>
    <form action="manage.php" method="post">
        <label for="eoi_number">EOI Number:</label>
        <input type="text" id="eoi_number" name="eoi_number" required placeholder="">
        <label for="new_status">New Status:</label>
        <input type="text" id="new_status" name="new_status" required placeholder="New/Current/Final"
            pattern="^(New|Current|Final)$" title="Please enter New, Current, or Final">
        <button type="submit" name="change_status" class="eoi-button">Change Status</button>
    </form>

    </main>
    <?php include "footer.inc"; ?>
</body>
</html>


