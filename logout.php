<?php
    session_start();
    session_regenerate_id();
    $_SESSION["gatekeeper"] = null;
    $_SESSION["admin"] = null;
    session_unset();
    session_destroy();
    header("Location: index.php");
?>