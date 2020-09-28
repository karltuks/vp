<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_karl_tuks_3";
if (isset($_POST["submitnonsens"])) {
    if(!empty($_POST["nonsens"])) {
        //andmebaasi lisamine
        //loome andmebaasi ühenduse
        $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
        //valmistame ette SQL käsu
        $stmt = $conn->prepare("INSERT INTO nonsens (nonsensidea) VALUES(?)");
        echo $conn->error;
        //s - string, i -integer, d-decimal
        $stmt->bind_param("s", $_POST["nonsens"]);
        $stmt->execute();
        //käsk ja ühendus sulgeda
        $stmt->close();
        $conn->close();

    }
}

   //loeme andmebaasist
   $nonsenshtml = "";
   $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
   //valmistame ette SQL käsku
   $stmt = $conn->prepare("SELECT nonsensidea FROM nonsens");
   echo $conn->error;
   //seome tulemuse mingi muutujaga
   $stmt->bind_result($nonsensfromdb);
   $stmt->execute();
   //võtan, kuni on
   while($stmt->fetch()) {
       //<p>suvaline mõte </p>
       $nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
   }
       
    $stmt->close();
    $conn->close();
    
    $username = "Karl Tüksammel";
    require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
<h1><?php echo $username; ?> programmeerib veebi</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalokiokida mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
<ul>
  <li><a href="home.php">Tagasi pealehele!</a></li>
</ul>
<hr>
<?php echo $nonsenshtml; ?>
</body>
</html>

