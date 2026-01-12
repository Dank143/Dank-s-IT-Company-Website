<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/enhancements.js"></script>
  <title>Home - Dank's IT Company</title>
</head>
<body>
  <?php
    $activePage = "index";
    $pageTitle = "Dank's IT Company";
    include 'header.inc'; 
    include 'menu.inc'; 
  ?>
  <main>
    <section class="welcome">
      <h2>Welcome to Dank's IT Company!</h2>
      <p class="tagline">We are a leading IT company dedicated to providing innovative solutions. We stand and live up to our motto: Keep Moving Forward!</p>
    </section>
    
    <section class="info">
      <div class="info-item">
        <img src="images/why.jpeg" alt="Why Us">
        <h3>Why Us?</h3>
        <p>Simple, because at Dank's IT Company, we stand out for our commitment to excellence and innovation. With a proven track record of delivering cutting-edge solutions, our team of experts brings a wealth of experience to the table. Our tailored approach to each project ensures that we understand the unique challenges and goals of our clients. We pride ourselves on our ability to not only meet but exceed expectations. By choosing us, you're choosing a partner dedicated to providing outstanding IT solutions that drive your business forward.</p>
      </div>
      <div class="info-item">
        <img src="images/service.jpg" alt="Our Services">
        <h3>Our Services...</h3>
        <p>At Dank's IT Company, our comprehensive range of IT services caters to a wide spectrum of needs. From robust software development and efficient network management to secure data solutions and advanced AI integration, we cover all aspects of the IT landscape. Our expert team is well-versed in cloud computing, cybersecurity, application development, and more. Whether you're a startup seeking innovative technology solutions or an established enterprise aiming to streamline processes, our diverse services are designed to help you achieve your objectives.</p>
      </div>
      <div class="info-item">
        <img src="images/join.jpg" alt="Join the Team">
        <h3>Join the Team!</h3>
        <p>Joining Dank's IT Company means becoming a part of a dynamic and collaborative team. We foster an environment that encourages creativity, continuous learning, and professional growth. As a member of our team, you'll have the opportunity to work on exciting projects that push the boundaries of technology. Whether you're a software engineer, data analyst, or project manager, you'll contribute to impactful solutions that make a difference. We value diversity and our supportive culture ensures that you'll be empowered to excel in your role.</p>
      </div>
    </section>

    <div id="assistance-modal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close" id="close-modal">&times;</span>
          <h2>Need any assistance?</h2>
        </div>
        <div class="modal-body">
          <p class="highlight"> We are always here for you. Contact us during business hours and our friendly staffs will get back to you within 24 hours.</p><br>
          <p class="highlight">🕓 Operating hours:</p>
          <p>Monday - Friday: 09:00 - 17:00</p>
          <p>Saturday - Sunday: 09:00 - 12:00</p><br>
          <p><span class="highlight">⟟ Location:</span> Melbourne, VIC, Australia</p><br>
          <p><span class="highlight">✉ Email:</span> <a href="mailto:honghuea3@gmail.com">honghuea3@gmail.com</a></p>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </main>
  <?php include "footer.inc"; ?>
</body>
</html>


