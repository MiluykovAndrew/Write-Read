<?php
    $connection = mysqli_connect("localhost", "root", "", "blog");
    if (!$connection) { echo "Ошибка соединения"; exit(); }