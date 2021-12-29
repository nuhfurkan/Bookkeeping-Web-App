<?php
    require "config.php";

    $kisiIsim = $_GET["isim"];

    $kisi = str_replace("@", " ", $kisiIsim);
    $sqlKisi = "SELECT id, firstname FROM kisiler WHERE BINARY firstname='$kisiIsim'";
    
    $resultKisi = $conn->query($sqlKisi);
    if($resultKisi->num_rows > 0) {
        die ("this person exists");
    } else {
        $sql = "INSERT INTO kisiler (firstname) VALUES ('$kisiIsim')";

        $conn->query($sql);
    }
?>