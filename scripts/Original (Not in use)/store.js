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
  
  