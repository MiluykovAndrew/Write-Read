<?php
    setcookie('log', false, time() - 3600, '/');
    header('location: /auth.php');