<?php
// test_session.php
header('Content-Type: application/json; charset=utf-8');

// DEBUG: affiche infos session / cookies
session_start();

echo json_encode([
    'ok' => true,
    'session_id' => session_id(),
    'session_name' => session_name(),
    'cookie_present' => isset($_COOKIE[session_name()]) ? true : false,
    'cookie_value' => isset($_COOKIE[session_name()]) ? $_COOKIE[session_name()] : null,
    'session_keys' => array_keys($_SESSION),
    'session_contents' => $_SESSION
], JSON_PRETTY_PRINT);
