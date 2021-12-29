<?php
    require "config.php";

    $kisi = $_GET['kisi'];
    $doviz = $_GET["doviz"];
    $islem = $_GET["islem"];

    $kisi = str_replace("@", " ", $kisi);
    #echo "kisi adi " . $kisi. "<br>";

    $sqlKisi = "SELECT id, firstname FROM kisiler WHERE BINARY firstname='$kisi'";
    if ($kisi == "hepsi") {
        $sqlKisi = "SELECT id, firstname FROM kisiler";
    }

    $resultKisi = $conn->query($sqlKisi);

    if($resultKisi->num_rows > 0) {

        while($rowKisi = $resultKisi->fetch_assoc()) {
            $kisiId = $rowKisi["id"];

            $sqlDoviz = "SELECT id, isim FROM dovizler WHERE BINARY isim='$doviz'";

            if ($doviz == "hepsi") {
                $sqlDoviz = "SELECT id, isim FROM dovizler";
            }
        
            $resultDoviz = $conn->query($sqlDoviz);
            if($resultDoviz->num_rows > 0) {

                while($rowDoviz = $resultDoviz->fetch_assoc()) {
                    $dovizId = $rowDoviz["id"];
                    #echo "id is ". $rowDoviz["id"]. " isim is " .$rowDoviz["isim"]."<br>";

                    $sql = "SELECT cins, tarih, kisi, tutar, islem, aciklama FROM islemler WHERE islem='$islem' and cins='$dovizId' and kisi='$kisiId'";

                    if ($islem == "hepsi") {
                        $sql = "SELECT id, cins, tarih, kisi, tutar, islem, aciklama FROM islemler WHERE cins='$dovizId' and kisi='$kisiId'";
                    }
                
                    $result = $conn->query($sql);
                
                    if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                        if ($row['islem'] == "tahsil") {
                            echo "<tr>
                            <td><div class='popup' onmouseenter='popUpFunction(".$row["id"].")' onmouseleave='popUpFunction(".$row["id"].")'>(?)
                            <span class='popuptext' id=".$row["id"].">".$row['aciklama']."</span>
                          </div></td>
                            <td>". $row['tarih']."</td>
                            <td>". $rowKisi["firstname"] ."</td>
                            <td>". $row['tutar'] ."</td>
                            <td>". $rowDoviz["isim"] ."</td>
                            <td> <input type='button' value='sil' onclick='sil(".$row['id'].")' id=".$row['id']."> </td>
                        </tr>";
                        } else {
                            echo "<tr style='background-color: rgb(124, 0, 0);'>
                            <td><div class='popup' onmouseenter='popUpFunction(".$row["id"].")' onmouseleave='popUpFunction(".$row["id"].")'>(?)
                            <span class='popuptext' id=".$row["id"].">".$row['aciklama']."</span>
                          </div></td>
                            <td>". $row['tarih']."</td>
                            <td>". $rowKisi["firstname"] ."</td>
                            <td>". $row['tutar'] ."</td>
                            <td>". $rowDoviz["isim"] ."</td>
                            <td> <input type='button' value='sil' onclick='sil(".$row['id'].")' id=".$row['id']."> </td>
                        </tr>";
                        }
                        if ($row["islem"] == "tahsil") {
                            $bakiyeler[$rowDoviz["isim"]] += $row["tutar"];
                        } else {
                            $bakiyeler[$rowDoviz["isim"]] -= $row["tutar"];
                        }
                        
                        #echo "id: " . $row["id"]. " - Name: " . $row["kisi"]. " " . $row["tutar"]. "<br>";
                      }
                    } else {
                      #echo "0 results";
                    }
                }
            } else {
                die ("no such doviz found ". $doviz);
            }
            #echo $rowKisi["firstname"]. "<br>";
        }
    } else {
        die ("no such person found ". $kisi);
    }


        echo "@@<table class='tableView2'><tr>";
    foreach($bakiyeler as $x => $x_value) {
        echo "<th>".$x. " -> " .$x_value."</th>";
      }

      echo "</tr></table>";
?>