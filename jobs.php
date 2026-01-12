<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles/styles.css" rel="stylesheet">
  <script src="scripts/apply.js"></script>
  <script src="scripts/enhancements.js"></script>
  <title>Position Descriptions - Dank's IT Company</title>
</head>
<body>
  <?php
    $activePage = "jobs";
    $pageTitle = "Jobs Description"; 
    include 'header.inc';
    include 'menu.inc'; 
  ?>
  <main>
    <aside>The following positions are being offered:</aside>
    <section class="jobs">
      <div class="job-slider">
        <div class="job-container">

          <div class="job-content">
            <h2>Job Position: Database Administrator</h2>
            <h3>Description</h3>
            <p>We are seeking a skilled Database Administrator to manage, maintain, and optimize our organization's databases, ensuring data integrity, security, and availability.</p>
            <ol> 
                <li><h3>Position Details</h3>
                  <ul>
                      <li>Reference Number: DA123</li>
                      <li>Salary Range: $85,000 - $110,000 per year</li>
                      <li>Reports to: IT Manager</li>
                  </ul>
                </li>
                <li><h3>Key Responsibilities</h3>
                  <ul>
                      <li>Install, configure, and upgrade database software</li>
                      <li>Design and implement backup and recovery solutions</li>
                      <li>Monitor database performance and resolve performance issues</li>
                      <li>Create and manage user accounts and permissions</li>
                      <li>Ensure data security and implement access controls</li>
                  </ul>
                </li>
                <li><h3>Required Qualifications</h3>
                  <ul>
                      <li>Essential:
                          <ul>
                              <li>Bachelor's degree in Computer Science or related field</li>
                              <li>3+ years of experience as a Database Administrator</li>
                              <li>Strong knowledge of SQL and database management systems</li>
                          </ul>
                      </li>
                      <li>Preferable:
                          <ul>
                              <li>Certification in database administration (e.g., Oracle, Microsoft)</li>
                              <li>Experience with cloud database services</li>
                          </ul>
                      </li>
                  </ul>
                </li>
            </ol>    
            <a class="apply-button" href="apply.php" data-job-reference="DA123">Apply</a>
          </div>
        </div>
        <div class="job-container">

          <div class="job-content">
            <h2>Job Position: IT Project Manager</h2>
            <h3>Description</h3>
            <p>We are seeking an experienced IT Project Manager to lead and manage our technology projects, ensuring timely delivery and alignment with business goals.</p>
            <ol>   
                <li><h3>Position Details</h3>
                  <ul>
                      <li>Reference Number: PM069</li>
                      <li>Salary Range: $80,000 - $110,000 per year</li>
                      <li>Reports to: Director of Technology</li>
                  </ul>
                </li>
                <li><h3>Key Responsibilities</h3>
                  <ul>
                      <li>Define project scope, goals, and deliverables</li>
                      <li>Develop and manage project plans, schedules, and budgets</li>
                      <li>Coordinate project team members and resources</li>
                      <li>Monitor and report project progress to stakeholders</li>
                      <li>Resolve issues and risks that arise during projects</li>
                  </ul>
                </li>
                <li><h3>Required Qualifications</h3>
                  <ul>
                      <li>Essential:
                          <ul>
                              <li>Bachelor's degree in IT or related field</li>
                              <li>5+ years of project management experience</li>
                              <li>Strong leadership and communication skills</li>
                          </ul>
                      </li>
                      <li>Preferable:
                          <ul>
                              <li>PMP certification</li>
                              <li>Experience in Agile methodologies</li>
                          </ul>
                      </li>
                  </ul> 
                </li>
            </ol>
            <a class="apply-button" href="apply.php" data-job-reference="PM069">Apply</a>
          </div>
        </div>
        <div class="job-container">

          <div class="job-content">
            <h2>Job Position: AI Solutions Engineer</h2>
            <h3>Description</h3>
            <p>Join our innovative team as an AI Solutions Engineer, where you'll design and implement cutting-edge artificial intelligence solutions for diverse business challenges.</p>
            <ol>
                <li><h3>Position Details</h3>
                  <ul>
                      <li>Reference Number: AI420</li>
                      <li>Salary Range: $90,000 - $120,000 per year</li>
                      <li>Reports to: Chief Technology Officer</li>
                  </ul>
                </li>
                <li><h3>Key Responsibilities</h3>
                  <ul>
                      <li>Collaborate with clients to understand AI requirements</li>
                      <li>Design and develop AI models and algorithms</li>
                      <li>Integrate AI solutions into existing systems</li>
                      <li>Evaluate and optimize AI performance</li>
                      <li>Provide technical guidance to project teams</li>
                  </ul>
                </li>
                <li><h3>Required Qualifications</h3>
                  <ul>
                      <li>Essential:
                          <ul>
                              <li>Master's degree in Computer Science or related field</li>
                              <li>3+ years of experience in AI and machine learning</li>
                              <li>Proficiency in Python and TensorFlow</li>
                          </ul>
                      </li>
                      <li>Preferable:
                          <ul>
                              <li>Experience with natural language processing</li>
                              <li>Published AI research papers</li>
                          </ul>
                      </li>
                  </ul>
                </li>
            </ol>
            <a class="apply-button" href="apply.php" data-job-reference="AI420">Apply</a>
          </div>
        </div>
      </div>
    </section>
    <div class="slider-controls">
    <div class="navigation-dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
    <button class="prev-button">Back</button>
    <button class="next-button">Next</button>
    </div>
  </main>
  <?php include "footer.inc"; ?>
</body>
</html>
