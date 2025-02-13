<?php

if (isset($_GET['logout'])){

    session_destroy();
    unset($_SESSION['company_id']);
    header('Location: login.php');
}

?>
