<?php
require_once __DIR__ . "/config/session.php";


logout();


header("Location: login.php");
exit;