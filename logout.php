<?php
require_once __DIR__ . "/config/session.php";

// shkaterron session-in
logout();

// ridrejton te login
header("Location: login.php");
exit;