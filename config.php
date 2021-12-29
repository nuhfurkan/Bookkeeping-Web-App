<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "muhasebe";


    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        #echo "something...". "<br>";
        die("Connection failed: " . $conn->connect_error);
    } else {
        #echo "success <br>";
    }

    #LIKE 'muhasebe'
    $sql = "SHOW DATABASES LIKE 'muhasebe'";

    $n=0;
    foreach ($conn->query($sql) as $val) {
        $n=$n+1;
    }
    #echo $n;

    if ($n != 0) {
        #echo "Database found successfully". "<br>";
    } else {

        ### BURADA TABLE OLUSTURMA KISMI OLACAK ###
    
        #echo "No such db found!". "<br>";
        $newsql = "CREATE DATABASE muhasebe";
        if ($conn->query($newsql) === TRUE) {            
            #echo "Database created successfully". "<br>";
        } else {
            die("Creating database failed: " . $conn->error. "<br>"); 
            #echo "Error creating database: " . $conn->error. "<br>";
        }

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            #echo "something...". "<br>";
            die("Connection failed: " . $conn->connect_error);
        }


        $crttbl = "CREATE TABLE kisiler (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            firstname VARCHAR(30) NOT NULL
            )";

        if ($conn->query($crttbl) === TRUE) {
            #echo "Table kisiler created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        $crtdvz = "CREATE TABLE dovizler (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            isim VARCHAR(30) NOT NULL
            )";

        if ($conn->query($crtdvz) === TRUE) {
           # echo "Table dovizler created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }

        $crtislm = "CREATE TABLE islemler (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            tarih DATETIME DEFAULT CURDATE(),
            islem VARCHAR(30) NOT NULL,
            cins INT,
            kisi INT,
            tutar INT NOT NULL,
            aciklama VARCHAR(30) NOT NULL,
            CONSTRAINT FK_kisiID FOREIGN KEY (kisi) REFERENCES kisiler(id),
            CONSTRAINT FK_dovizID FOREIGN KEY (cins) REFERENCES dovizler(id)
            )";

        if ($conn->query($crtislm) === TRUE) {
           # echo "Table islemler created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        #echo "something...". "<br>";
        die("Connection failed: " . $conn->connect_error);
    }    

    function connKill() {
        $conn->close();
    }

    #echo "Connected successfully". "<br>"; 
?>