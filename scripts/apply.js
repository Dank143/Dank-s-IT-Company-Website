"use strict";

// Function to initialize the form and validation
function init() {
  const form = document.getElementById('application-form');
  form.addEventListener('submit', function (event) {
    const dobInput = document.getElementById('date-of-birth');
    const stateSelect = document.getElementById('state');
    const postcodeInput = document.getElementById('postcode');
    const skillsCheckboxes = document.querySelectorAll('input[name="skills"]');
    const otherSkillsTextarea = document.getElementById('other-skills');
    let isValid = true;

    // Clear any previous error messages
    clearErrorMessages();

    // Check applicant's age
    const dobParts = dobInput.value.split('/');
    const dobYear = parseInt(dobParts[2], 10);
    const currentYear = new Date().getFullYear();
    if (dobYear < currentYear - 80 || dobYear > currentYear - 15) {
      isValid = false;
      displayErrorMessage('dob-error', 'Applicants must be between 15 and 80 years old');
    }    
    
    // Check if the date is valid (e.g., not February 30th)
    if (!isValidDate(dobInput.value)) {
      isValid = false;
      displayErrorMessage('dob-error', 'Please enter a valid date based on the dd/mm/yyyy format');
    }

    // Validate State and Postcode
    const stateToPostcodeMap = {
      VIC: ['3', '8'],
      NSW: ['1', '2'],
      QLD: ['4', '9'],
      NT: ['0'],
      WA: ['6'],
      SA: ['5'],
      TAS: ['7'],
      ACT: ['0'],
    };
    const selectedState = stateSelect.value;
    const postcode = postcodeInput.value;
    if (!stateToPostcodeMap[selectedState] || !stateToPostcodeMap[selectedState].includes(postcode[0])) {
      isValid = false;
      displayErrorMessage('postcode-error', 'The selected state does not match the first digit of the postcode');
    }

    // Validate Other Skills
    const otherSkillsCheckbox = document.querySelector('input[name="skills"][value="other-skills"]');
    if (otherSkillsCheckbox.checked && otherSkillsTextarea.value.trim() === '') {
      isValid = false;
      displayErrorMessage('other-skills-error', 'Other skills cannot be blank. Please enter descriptions in the text area');
    }

    // Display error message if validation fails
    if (!isValid) {
      event.preventDefault(); // Prevent form submission
    }
  });

  // Add event listener to the "Reset" button
  const resetButton = document.getElementById('reset-button');
  if (resetButton) {
    resetButton.addEventListener('click', function () {
      // Clear stored data
      sessionStorage.removeItem('jobReference');
      sessionStorage.removeItem('userDetails');

      // Reset form fields
      form.reset(); // This will reset all form fields to their initial values
      clearErrorMessages(); // Call clearErrorMessages to clear error messages
    });
  }
}

// Function to display error message for a specific input
function displayErrorMessage(errorId, message) {
  const errorSpan = document.getElementById(errorId);
  errorSpan.textContent = `(Error: ${message})`;
}

// Function to clear all error messages
function clearErrorMessages() {
  const errorMessages = document.querySelectorAll('.error-message');
  errorMessages.forEach(function (errorMessage) {
    errorMessage.textContent = '';
  });
}

// Function to check if a date is valid
function isValidDate(dateString) {
  const parts = dateString.split('/');
  const day = parseInt(parts[0], 10);
  const month = parseInt(parts[1], 10) - 1; // Month is zero-indexed
  const year = parseInt(parts[2], 10);
  const date = new Date(year, month, day);
  return (
    date.getDate() === day &&
    date.getMonth() === month &&
    date.getFullYear() === year
  );
}

// Store job reference number upon clicking the apply button
document.addEventListener('DOMContentLoaded', function () {
  // Get all elements with the class "apply-button"
  var applyButtons = document.querySelectorAll('.apply-button');

  // Add click event listeners to each "Apply" button
  applyButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      var jobReference = event.currentTarget.getAttribute('data-job-reference');

      if (jobReference) {
        sessionStorage.setItem('jobReference', jobReference);
      }
    });
  });

  // Fill the input field with the stored job reference number
  var jobReferenceInput = document.getElementById('job-reference');
  var storedJobReference = sessionStorage.getItem('jobReference');

  if (jobReferenceInput && storedJobReference) {
    jobReferenceInput.value = storedJobReference;
  }
});

// Store other datas
document.addEventListener('DOMContentLoaded', function () {
  // Check if there are stored user details in session storage
  var storedUserDetails = sessionStorage.getItem('userDetails');
  var applicationForm = document.getElementById('application-form');

  // If stored user details exist, pre-fill the form fields
  if (storedUserDetails) {
    var userDetails = JSON.parse(storedUserDetails);

    // Pre-fill form fields
    if (applicationForm) {
      applicationForm['first-name'].value = userDetails.firstName;
      applicationForm['last-name'].value = userDetails.lastName;
      applicationForm['date-of-birth'].value = userDetails.dateOfBirth;
      applicationForm['gender'].value = userDetails.gender;
      applicationForm['street-address'].value = userDetails.streetAddress;
      applicationForm['suburb'].value = userDetails.suburb;
      applicationForm['state'].value = userDetails.state;
      applicationForm['postcode'].value = userDetails.postcode;
      applicationForm['email'].value = userDetails.email;
      applicationForm['phone'].value = userDetails.phone;

      // Pre-select skills checkboxes
      if (userDetails.skills && Array.isArray(userDetails.skills)) {
        userDetails.skills.forEach(function (skill) {
          var checkbox = applicationForm.querySelector('input[name="skills"][value="' + skill + '"]');
          if (checkbox) {
            checkbox.checked = true;
          }
        });
      }

      // Pre-fill other skills textarea
      if (userDetails.otherSkills) {
        applicationForm['other-skills'].value = userDetails.otherSkills;
      }
    }
  }

  // Listen for form submission to store user details
  if (applicationForm) {
    applicationForm.addEventListener('submit', function (event) {
      // Get user details from the form
      var firstName = applicationForm['first-name'].value;
      var lastName = applicationForm['last-name'].value;
      var dateOfBirth = applicationForm['date-of-birth'].value;
      var gender = applicationForm['gender'].value;
      var streetAddress = applicationForm['street-address'].value;
      var suburb = applicationForm['suburb'].value;
      var state = applicationForm['state'].value;
      var postcode = applicationForm['postcode'].value;
      var email = applicationForm['email'].value;
      var phone = applicationForm['phone'].value;

      // Get selected skills
      var skillsCheckboxes = applicationForm.querySelectorAll('input[name="skills"]:checked');
      var skills = [];
      skillsCheckboxes.forEach(function (checkbox) {
        skills.push(checkbox.value);
      });

      // Get other skills
      var otherSkills = applicationForm['other-skills'].value;

      // Create an object to store user details
      var userDetails = {
        firstName: firstName,
        lastName: lastName,
        dateOfBirth: dateOfBirth,
        gender: gender,
        streetAddress: streetAddress,
        suburb: suburb,
        state: state,
        postcode: postcode,
        email: email,
        phone: phone,
        skills: skills,
        otherSkills: otherSkills,
      };

      // Store user details in session storage
      sessionStorage.setItem('userDetails', JSON.stringify(userDetails));
    });
  }
});

// Additional Functions
function displayErrorMessage(errorId, message) {
  const errorSpan = document.getElementById(errorId);
  errorSpan.textContent = `(Error: ${message})`;
}

function clearErrorMessages() {
  const errorMessages = document.querySelectorAll('.error-message');
  errorMessages.forEach(function (errorMessage) {
    errorMessage.textContent = '';
  });
}

window.onload = init;
