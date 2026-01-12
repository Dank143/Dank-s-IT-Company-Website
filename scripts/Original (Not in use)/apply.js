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

    // Validate Date of Birth format (dd/mm/yyyy)
    const dobRegex = /^\d{2}\/\d{2}\/\d{4}$/;
    if (!dobRegex.test(dobInput.value)) {
      isValid = false;
      displayErrorMessage('dob-error', 'Please enter a valid date of birth in dd/mm/yyyy format');
    } else {
      // Check if the date is valid (e.g., not February 30th)
      if (!isValidDate(dobInput.value)) {
        isValid = false;
        displayErrorMessage('dob-error', 'Please enter a valid date');
      }

      const dobParts = dobInput.value.split('/');
      const dobYear = parseInt(dobParts[2], 10);
      const currentYear = new Date().getFullYear();
      if (dobYear < currentYear - 80 || dobYear > currentYear - 15) {
        isValid = false;
        displayErrorMessage('dob-error', 'Applicants must be between 15 and 80 years old');
      }
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

window.onload = init;