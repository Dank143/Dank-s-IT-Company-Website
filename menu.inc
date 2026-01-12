<nav>
  <ul>
    <li><a href="index.php" <?php echo ($activePage === 'index') ? 'class="active"' : ''; ?>>Home</a></li>
    <li><a href="jobs.php" <?php echo ($activePage === 'jobs') ? 'class="active"' : ''; ?>>Job Descriptions</a></li>
    <li><a href="apply.php" <?php echo ($activePage === 'apply') ? 'class="active"' : ''; ?>>Job Application</a></li>
	<li><a href="mailto:honghuea3@gmail.com">Contact Us</a></li>
    <li><a href="login.php" <?php echo ($activePage === 'login') ? 'class="active"' : ''; ?>>My Manager</a></li>
  </ul>
</nav>
