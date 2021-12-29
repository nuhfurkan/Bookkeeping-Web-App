<?php
    require "config.php";

    $q = $_GET["q"];

    $sql = "DELETE FROM islemler WHERE id='$q'";
    $conn->query($sql);

?>