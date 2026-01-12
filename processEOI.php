<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
  <title>Apply - Dank's IT Company</title>
</head>
<body>
    <?php
      $pageTitle = "Your Application";
      include "header.inc";
    ?>

    <main>
    <?php
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // If the page is accessed directly via a browser, redirect to another page
            header("Location: apply.php"); 
            exit;
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

        // Check if the EOI table exists, and create it if necessary
        $tableExistsQuery = "SHOW TABLES LIKE 'EOI'";
        $result = mysqli_query($connection, $tableExistsQuery);

        if (mysqli_num_rows($result) == 0) {
            // Create the EOI table if it doesn't exist
            $createTableQuery = "CREATE TABLE EOI (
                EOInumber INT AUTO_INCREMENT PRIMARY KEY,
                job_reference VARCHAR(10) NOT NULL,
                first_name VARCHAR(20) NOT NULL,
                last_name VARCHAR(20) NOT NULL,
                date_of_birth DATE NOT NULL,
                gender VARCHAR(10) NOT NULL,
                street_address VARCHAR(40) NOT NULL,
                suburb VARCHAR(40) NOT NULL,
                state VARCHAR(3) NOT NULL,
                postcode INT NOT NULL,
                email VARCHAR(50) NOT NULL,
                phone VARCHAR(12) NOT NULL,
                skills TEXT,
                other_skills TEXT,
                status ENUM('New', 'Current', 'Final') DEFAULT 'New' NOT NULL
            )";
            mysqli_query($connection, $createTableQuery);
        }

        // Initialize variables to store error messages
        $errors = array();

        // Function to sanitize and validate input
        function validateInput($input) {
            $input = trim($input); // Remove leading and trailing spaces
            $input = stripslashes($input); // Remove backslashes
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); // Sanitize HTML characters
            return $input;
        }

        // State-to-Postcode mapping
        $stateToPostcodeMap = [
            'VIC' => ['3', '8'],
            'NSW' => ['1', '2'],
            'QLD' => ['4', '9'],
            'NT'  => ['0'],
            'WA'  => ['6'],
            'SA'  => ['5'],
            'TAS' => ['7'],
            'ACT' => ['0'],
        ];

        // Handle Form Submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $job_reference = validateInput($_POST["job-reference"]);
            $first_name = validateInput($_POST["first-name"]);
            $last_name = validateInput($_POST["last-name"]);
            $date_of_birth = date("Y-m-d", strtotime(str_replace('/', '-', validateInput($_POST["date-of-birth"]))));
            $gender = validateInput($_POST["gender"]);
            $street_address = validateInput($_POST["street-address"]);
            $suburb = validateInput($_POST["suburb"]);
            $state = validateInput($_POST["state"]);
            $postcode = validateInput($_POST["postcode"]);
            $email = validateInput($_POST["email"]);
            $phone = validateInput($_POST["phone"]);

            // Check if "skills" is set in the POST data
            $skills = isset($_POST["skills"]) ? $_POST["skills"] : array();

            $other_skills = validateInput($_POST["other-skills"]);

            // Validate input based on requirements
            if (empty($job_reference) || !preg_match('/^[A-Za-z0-9]{5}$/', $job_reference)) {
                $errors[] = "Job reference number must be exactly 5 alphanumeric characters (e.g. DA123).";
            }

            if (empty($first_name) || !preg_match('/^[A-Za-z ]{1,20}$/', $first_name)) {
                $errors[] = "First name must be 20 alpha characters max.";
            }

            if (empty($last_name) || !preg_match('/^[A-Za-z ]{1,20}$/', $last_name)) {
                $errors[] = "Last name must be 20 alpha characters max.";
            }

            if (empty($date_of_birth) || !preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date_of_birth)) {
                $errors[] = "Please enter a valid date based on the dd/mm/yyyy format and date of birth must be between 15 and 80 years old.";
            } else {
                $dob_parts = explode('-', $date_of_birth);
                $dob_year = intval($dob_parts[0]);
                $current_year = date("Y");
                if ($dob_year < $current_year - 80 || $dob_year > $current_year - 15) {
                    $errors[] = "Date of birth must be between 15 and 80 years old";
                }
            }

            if (empty($gender)) {
                $errors[] = "Gender must be selected.";
            }

            if (empty($street_address) || strlen($street_address) > 40) {
                $errors[] = "Street address must be 40 characters max.";
            }

            if (empty($suburb) || strlen($suburb) > 40) {
                $errors[] = "Suburb/town must be 40 characters max.";
            }

            if (empty($state) || !array_key_exists($state, $stateToPostcodeMap) || !in_array($postcode[0], $stateToPostcodeMap[$state])) {
                $errors[] = "State and postcode do not match.";
            }

            if (empty($postcode) || !preg_match('/^[0-9]{4}$/', $postcode)) {
                $errors[] = "Postcode must be exactly 4 digits.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email address must be in a valid format.";
            }

            if (empty($phone) || !preg_match('/^[\d\s]{8,12}$/', $phone)) {
                $errors[] = "Phone number must be 8 to 12 digits, or spaces.";
            }

            if (in_array("other-skills", $skills) && empty($other_skills)) {
                $errors[] = "Other skills description must not be empty if 'Other skills' checkbox is selected.";
            }

            // If there are validation errors, display them
            if (!empty($errors)) {
                echo '<div class="error-message">';
                echo "Please fix the following errors:<ul>";
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul></div>";
                echo "<a class='back-button' href='apply.php'>Back to Jobs Application</a>";
            } else {
            // All data is valid, proceed to insert into the database
            $insertQuery = "INSERT INTO EOI (job_reference, first_name, last_name, date_of_birth, gender, street_address, suburb, state, postcode, email, phone, skills, other_skills, status)
                            VALUES ('$job_reference', '$first_name', '$last_name', '$date_of_birth', '$gender', '$street_address', '$suburb', '$state', $postcode, '$email', '$phone', '" . implode(", ", $skills) . "', '$other_skills', 'New')";


                if (mysqli_query($connection, $insertQuery)) {
                    // Insert successful, display confirmation message
                    $eoi_number = mysqli_insert_id($connection);
                    echo "<div class='confirmation-message'>";
                    echo "Thank you for submitting your Expression of Interest. Your EOI number is: <div class='application'> $eoi_number </div>";
                    echo "</div>";

                    echo "<a class='back-button' href='apply.php'>Back to Jobs Application</a>";
                } else {
                    echo "Error: " . $insertQuery . "<br>" . mysqli_error($connection);
                }
            }
        }

        // Close the Database Connection
        mysqli_close($connection);
    ?>

    </main>
    <?php include "footer.inc"; ?>
</body>
</html>


