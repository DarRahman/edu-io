# edu.io AI Coding Instructions

This guide provides essential context for AI agents working on the **edu.io** codebase, an interactive web education platform.

## 🏗️ Architecture & Tech Stack
- **Backend:** Native PHP 8+ (Procedural style).
- **Database:** MySQL/MariaDB using `mysqli` extension.
- **Frontend:** HTML5, CSS3 (Glassmorphism), Vanilla JavaScript (ES6+).
- **AI Integration:** Google Gemini API (Gemini 2.5 Flash) via PHP cURL.
- **Real-time Simulation:** AJAX Polling (Long-polling) for Multiplayer & Notifications.
- **Authentication:** Session-based (`$_SESSION['loggedInUser']`, `$_SESSION['role']`) with Google OAuth integration.
- **Access Control:** Role-based (Admin vs User).

## 📂 Key Files & Directories
- [koneksi.php](koneksi.php): Central database connection.
- [config.php](config.php): Global configuration and API keys.
- [includes/navbar.php](includes/navbar.php): Centralized navigation bar.
- [script.js](script.js): Global frontend logic, including session checks, UI interactions, and polling.
- [style.css](style.css): Global styling (Glassmorphism & Dark Mode).
- [api_multiplayer.php](api_multiplayer.php): JSON API for multiplayer game state.
- [api_invite.php](api_invite.php): JSON API for friend invitations.
- [about.php](about.php): About page with feedback form.
- [admin_dashboard.php](admin_dashboard.php): Admin control panel.

## 🛠️ Development Conventions

### 1. Database Operations
- Use `mysqli_query($conn, $query)` for database interactions.
- **Security:** Always use `mysqli_real_escape_string($conn, $data)` for user inputs.
- **New Tables:** `friends`, `quiz_rooms`, `quiz_participants`, `game_invites`, `feedback`.
- **Table Updates:** `users` table has `role` column ('admin', 'user').

### 2. Session & Auth
- Start every dynamic PHP file with `session_start()`.
- Check `$_SESSION['loggedInUser']` to verify authentication.
- Check `$_SESSION['role']` for admin-only pages.
- **Focus Mode:** Navbar is intentionally removed in `multiplayer_lobby.php` and `multiplayer_game.php`.

### 3. AI Integration
- **Model:** Gemini 2.5 Flash.
- **Endpoints:**
  - `ai_process.php`: Chatbot.
  - `ai_quiz_process.php`: Single player quiz generator.
  - `multiplayer_create.php`: Multiplayer quiz generator (Host).

### 4. Frontend Patterns
- **Notifications:** Use SweetAlert2 (`Swal.fire`) for all user feedback.
- **Icons:** FontAwesome 6.5.1.
- **Image Cropping:** Cropper.js implemented in `edit_profile.php`.

## 🧩 Project Features & Implementation Details

### 1. Multiplayer System (Race Mode)
- **Concept:** Asynchronous "Race" where players answer questions at their own pace.
- **Host:** Creates room -> Generates AI Quiz -> Waits in Lobby -> Starts Game.
- **Player:** Joins via PIN or Invite -> Waits in Lobby -> Answers Questions.
- **Tech:**
  - `multiplayer_create.php`: Host generates quiz (JSON stored in DB).
  - `multiplayer_lobby.php`: Waiting room with live player list (AJAX).
  - `multiplayer_game.php`: Player interface (No navbar, focus mode).
  - `api_multiplayer.php`: Handles state syncing and score updates.
  - `multiplayer_exit.php`: Handles safe exit and room cleanup.

### 2. Social & Friend System
- **Friends:** `friends.php` allows searching, adding, and accepting friends.
- **Invites:** `api_invite.php` handles sending/receiving game invites.
- **Polling:** `script.js` polls for new invites every 5 seconds.

### 3. AI Integration
- **Chatbot:** Floating widget in `index.php`.
- **Quiz Generator:** Generates JSON-formatted questions for both single and multiplayer modes.

### 4. Gamification
- **Scoring:** `simpan_nilai.php` handles score submission.
- **Badges:** Automatically awarded for perfect scores (100).
- **Leaderboard:** `leaderboard.php` (Global ranking).

### 5. Community
- **Forum:** `forum.php` for Q&A with rating system.
- **Profile:** `profile.php` displays stats, badges, and friend list.

### 6. Admin & Feedback
- **Admin Panel:** `admin_dashboard.php` for managing users and viewing feedback.
- **Feedback:** `about.php` allows users/guests to send feedback (stored in `feedback` table).

## 🚀 Workflow
- **Local Dev:** XAMPP `htdocs/eduio`.
- **Database:** Ensure all tables (`friends`, `quiz_rooms`, etc.) are created.
- **Styling:** Maintain Glassmorphism consistency.
