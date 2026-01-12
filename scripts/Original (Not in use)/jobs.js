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
