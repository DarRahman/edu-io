# edu.io Copilot Instructions

## Project Overview
**edu.io** is a full-stack educational web platform for learning web development (HTML, CSS, JS).
- **Stack**: PHP (Native/Procedural), MySQL, HTML5, CSS3, Vanilla JavaScript.
- **AI Integration**: Google Gemini 2.5 Flash via `ai_process.php`.
- **Authentication**: PHP Sessions (Server-side) + `sessionStorage` (Client-side UI).

## Architecture & Core Components

### Backend (PHP)
- **Database Connection**: `koneksi.php` uses `mysqli` (procedural). Always include this for DB operations.
- **AI Proxy**: `ai_process.php` handles requests to Google Gemini API.
  - Expects JSON POST: `{ "history": [...], "name": "User" }`.
  - Returns JSON: `{ "reply": "..." }`.
- **Authentication**:
  - `login.php` & `register.php`: Handle auth logic.
  - `auth_google.php`: Handles Google OAuth 2.0.
  - **Session**: `session_start()` required on protected pages. Checks `$_SESSION['loggedInUser']`.

### Frontend (HTML/CSS/JS)
- **Structure**:
  - Root: Main pages (`index.html`, `forum.php`, `profile.php`).
  - `Materi/`: Learning modules (`materi-html.html`, etc.).
  - `Kuis/`: Quizzes (`kuis-html.html`, etc.).
- **Global Logic**: `script.js` handles:
  - Auth checks (redirects if not logged in).
  - Dark mode toggling.
  - Visitor stats.
  - Navigation highlighting.
- **Styling**: `style.css` (Custom CSS).
- **Libraries**: SweetAlert2 (`Swal`) for alerts/modals.

## Key Conventions & Patterns

### 1. Database Interaction
- Use **Procedural MySQLi**: `mysqli_query($conn, $sql)`.
- **Sanitization**: Always use `mysqli_real_escape_string($conn, $var)` for user inputs.
- **Password Hashing**: Use `password_hash()` and `password_verify()`.

### 2. Frontend Path Handling
- **Subfolders**: Pages in `Materi/` and `Kuis/` need to handle paths dynamically.
- **JS Helper**: `script.js` calculates `pathPrefix` (`../` or empty) based on `window.location.pathname`. Use this for links/redirects in JS.

### 3. UI/UX Patterns
- **Alerts**: Do NOT use native `alert()`. Use `Swal.fire()` with theme support.
  ```javascript
  Swal.fire({
      background: isDarkMode ? '#27273a' : '#fff',
      color: isDarkMode ? '#e0e0e0' : '#333',
      icon: 'success',
      title: 'Title',
      text: 'Message'
  });
  ```
- **Dark Mode**: Check `document.documentElement.classList.contains("dark-mode")` or `localStorage.getItem('theme')`.

### 4. AI Integration Pattern
- **Chat Interface**: Frontend sends chat history to `ai_process.php`.
- **Context**: The backend injects a system instruction ("Kamu adalah AI Tutor edu.io...") before sending to Gemini.

## Critical Workflows
- **Login Flow**:
  1. User POSTs to `login.php`.
  2. PHP verifies password.
  3. PHP sets `$_SESSION`.
  4. PHP echoes JS to set `sessionStorage` and redirect.
- **Quiz Submission**:
  1. JS calculates score.
  2. JS POSTs to `simpan_nilai.php`.
  3. PHP updates database.

## File Map
- `koneksi.php`: Database configuration.
- `ai_process.php`: AI logic.
- `script.js`: Main frontend script.
- `style.css`: Main stylesheet.
- `login.php`: Login logic.
