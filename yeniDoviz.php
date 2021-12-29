<?php
    require "config.php";

    $dovizIsmi = $_GET["q"];

    $sql = "INSERT INTO dovizler (isim) VALUES ('$dovizIsmi')";
    $conn->query($sql);

?>