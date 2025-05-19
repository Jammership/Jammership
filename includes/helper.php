<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isUserLoggedIn(): bool
{
    return isset($_SESSION['id']);
}