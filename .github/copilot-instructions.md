# edu.io AI Coding Instructions

This guide provides essential context for AI agents working on the **edu.io** codebase, an interactive web education platform.

## 🏗️ Architecture & Tech Stack
- **Backend:** Native PHP 8+ (Procedural style).
- **Database:** MySQL/MariaDB using `mysqli` extension.
- **Frontend:** HTML5, CSS3 (Glassmorphism), Vanilla JavaScript (ES6+).
- **AI Integration:** Google Gemini API (Gemini 2.5 Flash) via PHP cURL.
- **Authentication:** Session-based (`$_SESSION['loggedInUser']`) with Google OAuth integration.

## 📂 Key Files & Directories
- [koneksi.php](koneksi.php): Central database connection. Always include this for DB operations.
- [config.php](config.php): Global configuration and API keys (e.g., `$apiKey` for Gemini).
- [includes/navbar.php](includes/navbar.php): Centralized navigation bar. Include this in all pages.
- [script.js](script.js): Global frontend logic, including session checks and UI interactions.
- [style.css](style.css): Global styling, implementing dark mode and glassmorphism.
- [ai_process.php](ai_process.php): Backend handler for the AI Tutor chatbot.
- [Materi/](Materi/): PHP modules for learning content.
- [Kuis/](Kuis/): PHP modules for quizzes.

## 🛠️ Development Conventions

### 1. Database Operations
- Use `mysqli_query($conn, $query)` for database interactions.
- **Security:** Always use `mysqli_real_escape_string($conn, $data)` for user inputs to prevent SQL injection.
- Example:
  ```php
  $question = mysqli_real_escape_string($conn, $_POST['question']);
  mysqli_query($conn, "INSERT INTO forum_questions (username, question) VALUES ('$currentUser', '$question')");
  ```

### 2. Session & Auth
- Start every dynamic PHP file with `session_start()`.
- Check `$_SESSION['loggedInUser']` to verify if a user is authenticated.
- Public pages: `login.php`, `register.php`, `index.php`.

### 3. AI Integration
- Gemini API calls are handled via cURL in [ai_process.php](ai_process.php).
- Use the `$apiKey` from [config.php](config.php).
- System instructions for the AI are defined in the `$systemInstruction` variable.

### 4. Frontend Patterns
- **Notifications:** Use SweetAlert2 (`Swal.fire`) for all user feedback (success, error, alerts).
- **Icons:** Use FontAwesome 6.5.1 classes (e.g., `fas fa-bars`).
- **Pathing:** [script.js](script.js) uses a `pathPrefix` logic to handle assets when the user is inside subfolders like `Materi/` or `Kuis/`.

### 5. Gamification
- Scores are saved via [simpan_nilai.php](simpan_nilai.php).
- Badges are awarded automatically when a user achieves a score of 100.
- Badge types: `html_master`, `css_wizard`, `js_ninja`.

## 🧩 Project Features & Implementation Details

### 1. AI Integration (Gemini 2.5 Flash)
- **AI Tutor Chatbot:**
  - **Backend:** `ai_process.php` handles requests via cURL.
  - **Frontend:** Chat interface in `index.php` (floating widget).
  - **Context:** System instruction defines the persona as a friendly coding tutor.
- **AI Quiz Generator:**
  - **Backend:** `ai_quiz_process.php` generates JSON-formatted questions.
  - **Frontend:** `ai_quiz.php` renders dynamic quizzes.
  - **Logic:** User inputs a topic -> AI generates 5 multiple-choice questions -> User answers -> Score saved.

### 2. Gamification System
- **Scoring:** `simpan_nilai.php` handles score submission (`INSERT ... ON DUPLICATE KEY UPDATE`).
- **Badges:** Automatically awarded when score == 100.
  - **Types:** `html_master`, `css_wizard`, `js_ninja`, `expert_[topic]`.
  - **Storage:** `badges` table.
- **Leaderboard:** `leaderboard.php` displays top users based on total score.

### 3. Learning Modules
- **Content:** `Materi/` (PHP files) and `video.php` (YouTube embeds).
- **Playground:** `playground.php` provides a live coding environment (HTML/CSS/JS) with real-time preview.
- **Quizzes:** `Kuis/` folder contains PHP quizzes; `ai_quiz.php` for dynamic ones.

### 4. Community & Social
- **Forum:** `forum.php` allows Q&A.
  - **Features:** Post questions, answer, rate answers (star rating), delete own posts.
  - **Database:** `forum_questions`, `forum_answers`, `forum_ratings`.
- **User Profiles:** `profile.php` shows stats, badges, and activity.
- **Visitor Stats:** `visitor_stats.php` tracks online users (session-based) and total visits (cookie-based).

### 5. Authentication & Security
- **Google OAuth:** `auth_google.php` uses Google Identity Services.
- **Local Auth:** `login.php` / `register.php` with `password_hash`.
- **Session Management:** `session_start()` required in all protected files.
- **Auto-Migration:** `visitor_stats.php` contains logic to auto-create missing tables (`online_users`, `site_stats`).

## 🚀 Workflow
- **Local Dev:** Project is designed to run in XAMPP `htdocs/eduio`.
- **Database:** Ensure `db_eduio` is created and `koneksi.php` is updated with local credentials.
- **Styling:** Follow the glassmorphism pattern (semi-transparent backgrounds, blurs) defined in [style.css](style.css).
