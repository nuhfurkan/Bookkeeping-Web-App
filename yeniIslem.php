<?php
    require "config.php";

    $kisiAdi = $_GET["isim"];
    $dovizAdi =$_GET["doviz"];
    $islem = $_GET["tur"];
    $tutar = $_GET["tutar"];
    $acik = $_GET["aciklama"];
    $kisiAdi = str_replace("@", " ", $kisiAdi);

    $sqlKisi = "SELECT id, firstname FROM kisiler WHERE BINARY firstname='$kisiAdi'";

    $resultKisi = $conn->query($sqlKisi);
    if($resultKisi->num_rows > 0) {

        while($rowKisi = $resultKisi->fetch_assoc()) {
            $kisiId = $rowKisi["id"];
            echo $rowKisi["firstname"]. "<br>";
        }
    } else {
        echo $kisiAdi. "<br>";
        die ("no such person found");
    }

    $sqlDoviz = "SELECT id, isim FROM dovizler WHERE BINARY isim='$dovizAdi'";
    $resultDoviz = $conn->query($sqlDoviz);
    if($resultDoviz->num_rows > 0) {
        echo "ptr2 <br>";
        while($rowDoviz = $resultDoviz->fetch_assoc()) {
            $dovizId = $rowDoviz["id"];
            echo "id is ". $rowDoviz["id"]. " isim is " .$rowDoviz["isim"]."<br>";
        }
    } else {
        die ("no such doviz found");
    }

    echo $kisiAdi;
    $sql = "INSERT INTO islemler (islem, cins, kisi, tutar, aciklama) VALUES ('$islem', '$dovizId', '$kisiId', '$tutar', '$acik')";
    $conn->query($sql);
    echo "yeni islem kaydedildi";

?>