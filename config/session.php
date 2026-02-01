<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION["user"]);
}

function currentUser(): ?array
{
    return $_SESSION["user"] ?? null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function requireAdmin(): void
{
    requireLogin();
    if (($_SESSION["user"]["role"] ?? "") !== "admin") {
        header("Location: index.php");
        exit;
    }
}

function logout(): void
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $p = session_get_cookie_params();
        setcookie(session_name(), "", time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
    }
    session_destroy();
}
