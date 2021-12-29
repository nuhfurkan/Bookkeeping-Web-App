<?php
    require "config.php";
    
    $sql = "SELECT isim FROM dovizler";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<option value=\"".$row['isim']."\">".$row['isim']."</option>";
        }
      } else {
        echo "0 results";
      }
    
?>