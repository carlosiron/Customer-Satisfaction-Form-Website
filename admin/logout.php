<?php
/**
 * Admin Logout Handler
 *
 * Destroys the admin session and redirects to the login page.
 */

// --- Load backend dependencies ---
require_once __DIR__ . '/../helpers/AuthHelper.php';

// --- Perform logout (destroys session, redirects to login.php) ---
AuthHelper::logout();
