Dank's IT Company

### Overview
Dank's IT Company is a small PHP/MySQL web app demonstrating a basic recruitment workflow:
- Public marketing pages (Home, About)
- Job listings with a simple slider
- Job application form (EOI) with client- and server-side validation
- A manager portal (login required) to list/sort/filter/delete EOIs and manage interview candidates

This project was built for learning purposes and runs on plain PHP, MySQL/MariaDB, HTML, CSS, and vanilla JavaScript.


### Tech Stack
- PHP (sessions, mysqli)
- MySQL/MariaDB
- HTML5/CSS3
- Vanilla JavaScript (DOM APIs, sessionStorage)


### Project Structure
- Public pages
  - `index.php` – Landing page with modal assistance and confetti effect
  - `jobs.php` – Job descriptions with a simple slider and “Apply” CTAs
  - `apply.php` – EOI form; posts to `processEOI.php`
  - `processEOI.php` – Validates input and inserts EOI into DB (creates table if missing)
  - `about.php` – About page with timetable and profile
- Manager (auth required)
  - `login.php` – Simple session-based login (username: 1, password: 2)
  - `manage.php` – List/sort/filter/delete EOIs; update status (New/Current/Final)
  - `candidate.php` – Select candidates (≥ 3 skills) into a `Candidates` table, list and email them
  - `logout.php` – Logout confirmation and session clear
- Shared includes
  - `header.inc`, `footer.inc` – Shared header/footer
  - `menu.inc` – Main site navigation
  - `managerheader.inc`, `managermenu.inc` – Manager header/links
- Client assets
  - `styles/styles.css` – Global styles
  - `scripts/apply.js` – Client-side application form logic
  - `scripts/enhancements.js` – Back-to-top, job slider, modal+confetti, login countdown
- Database
  - `settings.php` – DB credentials (see Configuration)
  - `data.sql` – Optional sample EOI inserts 


### Getting Started

#### Prerequisites
- PHP 7.4+ (PHP 8.x recommended)
- MySQL/MariaDB
- A web server (Apache/Nginx) or PHP’s built-in server
- To launch a simple PHP web server for testing, use the following command: php -S localhost:8000

#### Configuration
DB credentials live in `settings.php`.
- Mercury server (default in repo): `feenix-mariadb.swin.edu.au` using the provided student credentials
- Local development: uncomment the localhost block and set your local DB details

Important: Do not commit real credentials in production projects. Use environment variables or a separate, ignored config file.


#### Database
`processEOI.php` will auto-create the `EOI` table if it does not exist. Table definition used in app:

```sql
CREATE TABLE EOI (
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
  status ENUM('New','Current','Final') DEFAULT 'New' NOT NULL
);
```

Optional: Seed sample data
- Ensure `EOI` exists first (either submit a sample EOI through the form or create the table manually)
- Run the inserts from `data.sql` against your database


#### Run Locally (simple)
1) Configure DB in `settings.php` (switch to localhost if needed)
2) Start PHP dev server from the project root:
   ```bash
   php -S localhost:8000
   ```
3) Open `http://localhost:8000` in your browser


### Usage

#### Public site
- Home (`index.php`): Company info, assistance modal with confetti after 10s, back-to-top button
- Jobs (`jobs.php`): Three roles (DA123, PM069, AI420) with a simple slider and “Apply” buttons
- Apply (`apply.php`): EOI form with client validation; job reference is auto-filled from the Jobs page via `sessionStorage`
- About (`about.php`): Profile, timetable, and bio

#### Manager portal
- Login (`login.php`): username `1`, password `2`; lockout for 15 seconds after 5 failed attempts
- Manage EOIs (`manage.php`):
  - List all EOIs
  - Sort by EOI No, Job Reference, First/Last name, Email, Number of skills, Status (asc/desc)
  - Filter by Job Reference (DA123, PM069, AI420 only)
  - Filter by applicant name (LIKE match)
  - Delete EOIs by Job Reference
  - Change status to New/Current/Final
- Candidates (`candidate.php`):
  - Pulls applicants with ≥ 3 skills into `Candidates` table (created on first use)
  - Lists candidates (Job ref, Name, Email, Phone, Skills, Status)
  - Sends a custom email message to all candidates via `mail()`


### Client-Side Behavior (JS)
- `scripts/apply.js`
  - Pre-fills the job reference on the Apply page based on the Jobs page selection
  - Stores and rehydrates form data via `sessionStorage`
  - Validates DOB range (15–80y), state/postcode mapping, and ensures “Other skills” text is filled when required
- `scripts/enhancements.js`
  - Back-to-top button
  - Jobs slider navigation and dot indicators
  - Assistance modal with confetti effect (Home page)
  - Simple countdown text update for login lockout message


### Styling
- Centralized CSS in `styles/styles.css` (typography, layout, slider, modal, tables, buttons)
- Custom fonts via `styles/head.ttf` and `styles/tech.ttf`


### Security & Data Notes
- Credentials are hardcoded in `settings.php` for demo. Do not do this in production.
- Queries are composed via string interpolation; consider parameterized queries (prepared statements) to prevent SQL injection.
- Email sending uses `mail()` which may not work in local environments without proper mail configuration.


### Known Issues / Caveats
- Candidates table column mismatch:
  - `candidate.php` displays `EOInumber` for candidates, but the schema created is `Candidatenumber`. Update the display to use the correct column or alias in SQL.
- Skills “Other” value mismatch in JS:
  - `apply.js` checks for a checkbox value of `other-skills`, but the HTML uses `Other`. Also, JS selectors sometimes use `name="skills"` while HTML uses `name="skills[]"`. Align names/values to ensure the “Other skills” requirement check works.
- `data.sql` assumes the `EOI` table already exists.
- Documentation mismatch around candidate selection threshold: code currently selects applicants with ≥ 3 skills. Standardize requirement across code and docs.


### Credits
- Enhancements and effects adapted from:
  - W3Schools (glowing text, modal, scroll-to-top, ORDER BY examples)
  - YouTube tutorials for slider and confetti effects


