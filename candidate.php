<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
  <title>Interview Candidates - Dank's IT Company</title>
</head>
<body>
    <?php 
      $activePage = "candidate";
      $pageTitle = "Interview Candidates";
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

        // Extract data from EOI table
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

        // Count the number of skills and insert qualified applicants into the "Candidates" table
        $countSkillsQuery = "SELECT * FROM EOI";
        $countSkillsResult = mysqli_query($connection, $countSkillsQuery);

        if ($countSkillsResult) {
            $interviewCandidates = [];

            while ($row = mysqli_fetch_assoc($countSkillsResult)) {
                $skills = explode(',', $row['skills']);
                if (count($skills) >= 3) {
                    $interviewCandidates[] = $row;
                }
            }

            if (!empty($interviewCandidates)) {
                $tableExistsQuery = "SHOW TABLES LIKE 'Candidates'";
                $tableExistsResult = mysqli_query($connection, $tableExistsQuery);

                if (mysqli_num_rows($tableExistsResult) == 0) {
                    $createInterviewTableQuery = "CREATE TABLE Candidates (
                        Candidatenumber INT AUTO_INCREMENT PRIMARY KEY,
                        job_reference VARCHAR(255),
                        first_name VARCHAR(255),
                        last_name VARCHAR(255),
                        email VARCHAR(255),
                        phone VARCHAR(255),
                        skills TEXT,
                        other_skills TEXT,
                        status VARCHAR(255)
                    )";

                    $createInterviewTableResult = mysqli_query($connection, $createInterviewTableQuery);

                    if (!$createInterviewTableResult) {
                        $error_message = "Error creating Interview Candidates table: " . mysqli_error($connection);
                    }
                }

                foreach ($interviewCandidates as $candidate) {
                    // Check for duplicates by email
                    $email = mysqli_real_escape_string($connection, $candidate['email']);
                    $checkDuplicateQuery = "SELECT * FROM Candidates WHERE email = '$email'";
                    $checkDuplicateResult = mysqli_query($connection, $checkDuplicateQuery);

                    if (mysqli_num_rows($checkDuplicateResult) == 0) {
                        // Candidate with this email does not exist, insert them
                        $job_reference = mysqli_real_escape_string($connection, $candidate['job_reference']);
                        $first_name = mysqli_real_escape_string($connection, $candidate['first_name']);
                        $last_name = mysqli_real_escape_string($connection, $candidate['last_name']);
                        $phone = mysqli_real_escape_string($connection, $candidate['phone']);
                        $skills = mysqli_real_escape_string($connection, $candidate['skills']);
                        $other_skills = mysqli_real_escape_string($connection, $candidate['other_skills']);
                        $status = mysqli_real_escape_string($connection, $candidate['status']);

                        $insertInterviewCandidateQuery = "INSERT INTO Candidates (job_reference, first_name, last_name, email, phone, skills, other_skills, status) VALUES ('$job_reference', '$first_name', '$last_name', '$email', '$phone', '$skills', '$other_skills', '$status')";

                        $insertInterviewCandidateResult = mysqli_query($connection, $insertInterviewCandidateQuery);

                        if (!$insertInterviewCandidateResult) {
                            $error_message = "Error inserting Interview Candidate: " . mysqli_error($connection);
                        }
                    }
                }
            }
        }

        // Display the "Candidates" table
        if (isset($_GET["display_candidates"])) {
            $candidatesQuery = "SELECT * FROM Candidates";
            $candidatesResult = mysqli_query($connection, $candidatesQuery);

            if ($candidatesResult) {
                $candidates = [];
                while ($row = mysqli_fetch_assoc($candidatesResult)) {
                    $candidates[] = $row;
                }

            } else {
                echo '<p class="fail-message">Error retrieving candidates: ' . mysqli_error($connection) . '</p>';
            }
        }
                
        if (isset($_POST['email_applicants'])) {
            // Get the custom message from the form
            $customMessage = $_POST['custom_message'];

            $subject = "Interview Invitation";
            $message = $customMessage; // Use the custom message provided
            $headers = "From: your_email@example.com";

            $query = "SELECT email FROM Candidates";
            $result = mysqli_query($connection, $query);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $to = $row['email'];
                    @ mail($to, $subject, $message, $headers);
                }
                $message = "The interview invitation email has been sent to all candidates.";
            } else {
                $error_message = "Error: " . mysqli_error($connection);
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

    <h2>Interview Candidates</h2>
    <p class="skill-requirement">(Only applicants with 3 or more skills will be considered for an interview)</p>
    <button onclick="window.location.href='candidate.php?display_candidates=1'" class="all-button">List All Candidates</button>
    <!-- List All EOIs -->
    <?php if (!empty($candidates)): ?>
    <div class="table-container">
        <table class="manage">
            <thead>
                <tr>
                    <th>Candidate No.</th>
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
                <?php foreach ($candidates as $candidate): ?>
                    <tr>
                        <td><?php echo $candidate['EOInumber']; ?></td>
                        <td><?php echo $candidate['job_reference']; ?></td>
                        <td><?php echo $candidate['first_name']; ?></td>
                        <td><?php echo $candidate['last_name']; ?></td>
                        <td><?php echo $candidate['email']; ?></td>
                        <td><?php echo $candidate['phone']; ?></td>
                        <td><?php echo $candidate['skills']; ?></td>
                        <td><?php echo $candidate['other_skills']; ?></td>
                        <td><?php echo $candidate['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Email Candidates -->
    <h2>Email interview to Candidates</h2>
    <form action="candidate.php" method="post">
        <label for="custom_message">Your Message:</label>
        <textarea id="custom_message" name="custom_message" rows="4" cols="50"></textarea>
        <br>
        <button type="submit" name="email_applicants" class="email-button">Email Applicants</button>
    </form>

    </main>
    <?php include "footer.inc"; ?>
</body>
</html>
