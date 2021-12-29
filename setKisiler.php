<?php
    require "config.php";
    
    $sql = "SELECT firstname FROM kisiler";
 
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        // output data of each row
        while($row = $res->fetch_assoc()) {
            $val = str_replace(" ", "@", $row['firstname']);
            echo "<option value=\"".$val."\">".$row['firstname']."</option>";
        }
      } else {
        echo "0 results";
      }

?>