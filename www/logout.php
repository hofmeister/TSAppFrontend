<?php
require_once 'bootstrap.php';

if (TS::isLoggedIn()) {
    session_destroy();
}

header('Location: /login.php');