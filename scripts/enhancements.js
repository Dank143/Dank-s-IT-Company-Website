"use scrict";

// Enhancement 1
document.addEventListener('DOMContentLoaded', function () {
// Back to top  
  const scrollButton = document.createElement('button');
  scrollButton.textContent = 'Back to Top';
  scrollButton.classList.add('back-to-top-button');
  document.body.appendChild(scrollButton);

  // Show the button when the user scrolls down
  window.addEventListener('scroll', function () {
    if (window.scrollY > 200) {
      scrollButton.style.display = 'block';
    } else {
      scrollButton.style.display = 'none';
    }
  });

  // Scroll to the top smoothly when the button is clicked
  scrollButton.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
});

// Sliding effect
document.addEventListener('DOMContentLoaded', function () {
  const jobContainers = document.querySelectorAll('.job-container');
  const dots = document.querySelectorAll('.dot');
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');

  let currentJobIndex = 0;

  function showJob(index) {
    jobContainers.forEach((container, i) => {
      container.style.transform = `translateX(-${index * 100}%)`;
    });

    dots.forEach((dot, i) => {
      dot.classList.remove('active');
      if (i === index) {
        dot.classList.add('active');
      }
    });
  }

  function navigateToJob(index) {
    currentJobIndex = index;
    showJob(index);
  }

  prevButton.addEventListener('click', () => {
    currentJobIndex = (currentJobIndex - 1 + jobContainers.length) % jobContainers.length;
    showJob(currentJobIndex);
  });

  nextButton.addEventListener('click', () => {
    currentJobIndex = (currentJobIndex + 1) % jobContainers.length;
    showJob(currentJobIndex);
  });

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      navigateToJob(index);
    });
  });

  showJob(currentJobIndex);
});

// Enhancement 2
document.addEventListener("DOMContentLoaded", function () {
  // Function to create and display the updated confetti
  function createConfetti() {
    const colors = ["red", "orange", "yellow", "blue", "cyan", "green", "magenta"];
    const modal = document.getElementById("assistance-modal");
    let screenWidth = window.innerWidth;

    // Create and append confetti elements
    for (let i = 0; i < 100; i++) {
      const confetti = document.createElement("div");
      confetti.className = "confetti";
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

      // Calculate left position based on screen width
      const leftPosition = Math.random() * screenWidth;
      confetti.style.left = leftPosition + "px";

      confetti.style.animationDelay = Math.random() * 4 + "s";
      modal.appendChild(confetti);
    }
  }

  // Update confetti positions when the window is resized
  function updateConfettiPositions() {
    const confettiElements = document.querySelectorAll(".confetti");
    let screenWidth = window.innerWidth;

    confettiElements.forEach(function (confetti) {
      const leftPosition = Math.random() * screenWidth;
      confetti.style.left = leftPosition + "px";
    });
  }

  // Display the modal
  function displayModal() {
    const modal = document.getElementById("assistance-modal");
    if (modal) {
      modal.style.display = "block";
      createConfetti(); // Create updated confetti when displaying modal
    }
  }

  // Set a timeout to display the modal after 10 seconds
  setTimeout(displayModal, 10000);

  // Close the modal and remove confetti when the close button is clicked
  const closeButton = document.getElementById("close-modal");
  if (closeButton) {
    closeButton.addEventListener("click", function () {
      const modal = document.getElementById("assistance-modal");
      if (modal) {
        modal.style.display = "none";
        // Remove confetti elements
        const confettiElements = modal.querySelectorAll(".confetti");
        confettiElements.forEach(function (confetti) {
          modal.removeChild(confetti);
        });
      }
    });
  }

  // Update confetti positions when the window is resized
  window.addEventListener("resize", updateConfettiPositions);
});

// Update countdown for login page
// Set the initial countdown time in seconds
var remainingTime = 10; // Adjust the time as needed
var countdownElement = document.querySelector(".fail-message");

// Function to update the countdown every second
function updateCountdown() {
    if (remainingTime > 0) {
        countdownElement.textContent = "Try again in " + remainingTime + " seconds.";
        remainingTime--;
    } else {
        // Countdown has ended, hide the error message
        countdownElement.style.display = "none";
        // Optionally, you can also stop any further countdown updates
        clearInterval(countdownInterval);
    }
}

// Call the updateCountdown function every second
var countdownInterval = setInterval(updateCountdown, 1000);

// Header movement on scroll (hide when scrolling down, show when scrolling up)
document.addEventListener('DOMContentLoaded', function () {
  var headerEl = document.querySelector('header');
  if (!headerEl) return;
  var lastY = window.pageYOffset || document.documentElement.scrollTop || 0;
  window.addEventListener('scroll', function () {
    var currentY = window.pageYOffset || document.documentElement.scrollTop || 0;
    if (currentY > lastY + 5) {
      headerEl.classList.add('header-hidden');
    } else if (currentY < lastY - 5 || currentY <= 0) {
      headerEl.classList.remove('header-hidden');
    }
    lastY = currentY;
  });
});








