<?php
    session_start();
    session_destroy();
    header("Location: ../view/landing_page.php");
?>