<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "padre") {
    header("Location: ../login.php");
    exit;
}

header("Location: dashboard.php");
exit;
