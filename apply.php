<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/apply.js"></script>
  <script src="scripts/enhancements.js"></script>
  <title>Apply - Dank's IT Company</title>
</head>
<body>
  <?php 
    $activePage = "apply";
    $pageTitle = "Job Application Form";
    include 'header.inc'; 
    include 'menu.inc'; 
  ?>
  <main class="apply">

    <form id="application-form" action="processEOI.php" method="post" novalidate="novalidate">
        <label for="job-reference">Job Reference Number:</label>
        <input type="text" id="job-reference" name="job-reference" placeholder="e.g. DA123" pattern="[A-Za-z0-9]{5}" required readonly><br>
        
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" name="first-name" required="required" maxlength="20" size="20" pattern="[A-Za-z ]+" title="Please enter alphabetic characters only."/><br>
        
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" name="last-name" required="required" maxlength="20" size="20" pattern="[A-Za-z ]+" title="Please enter alphabetic characters only."/><br>
        
        <label for="date-of-birth">Date of Birth: <span class="error-message" id="dob-error"></span></label>
        <input type="text" id="date-of-birth" name="date-of-birth" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" title="Please use the dd/mm/yyyy format only." required><br>

        <fieldset>
            <legend>Gender:</legend>
            <label><input type="radio" name="gender" value="Male" required> Male</label>
            <label><input type="radio" name="gender" value="Female"> Female</label>
            <label><input type="radio" name="gender" value="Other"> Other</label>
        </fieldset><br>
        
        <label for="street-address">Street Address:</label>
        <input type="text" id="street-address" name="street-address" maxlength="40" required><br>
        
        <label for="suburb">Suburb/Town:</label>
        <input type="text" id="suburb" name="suburb" maxlength="40" required><br>
        
        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value="" disabled selected>Select State</option> 
            <option value="VIC">VIC</option>
            <option value="NSW">NSW</option>
            <option value="QLD">QLD</option>
            <option value="NT">NT</option>
            <option value="WA">WA</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="ACT">ACT</option>
        </select><br>
        
        <label for="postcode">Postcode: <span class="error-message" id="postcode-error"></span></label>
        <input type="text" id="postcode" name="postcode" pattern="\d{4}" required><br>
        
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" pattern="\d{8,12}" maxlength="12" required><br>
        
        <label>Skills (Can be blank):</label>
        <input type="checkbox" name="skills[]" value="Programming"> Programming &nbsp;
        <input type="checkbox" name="skills[]" value="Database"> Database &nbsp;
        <input type="checkbox" name="skills[]" value="UI/UX"> UI/UX &nbsp;
        <input type="checkbox" name="skills[]" value="HR"> HR &nbsp;
        <input type="checkbox" name="skills[]" value="IT"> IT &nbsp;
        <input type="checkbox" name="skills[]" value="Cloud"> Cloud &nbsp;
        <input type="checkbox" name="skills[]" value="Leadership"> Leadership &nbsp;
        <input type="checkbox" name="skills[]" value="Presentation"> Presentation &nbsp;
        <input type="checkbox" name="skills[]" value="Market Analysis"> Market Analysis &nbsp;
        <input type="checkbox" name="skills[]" value="Other"> Other Skills<br>
        
        <br><label for="other-skills">Other Skills: <span class="error-message" id="other-skills-error"></span></label>
        <textarea id="other-skills" name="other-skills" rows="4"></textarea><br>
        
        <input type="submit" value="Apply">
        <button type="button" id="reset-button">Reset</button>
    </form>
</main>
<?php include "footer.inc"; ?>
</body>
</html>
