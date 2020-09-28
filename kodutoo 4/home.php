<?php


$username = "Karl Tüksammel";
//$fulltimenow = date("d.m.Y H:i:s");
$timenow = date("H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";
$daynow = date("d.");
$yearnow = date("Y");


//vaatame, mida vormist serverile saadetakse
var_dump($_POST);

$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow;
//küsime kuud
$monthnow = date("n");

if($hournow < 6){
	$partofday = "uneaeg";
}
if($hournow >= 6 and $hournow < 8) {
	$partofday = "hommikuste protseduuride aeg";
}
if($hournow >= 8 and $hournow < 18) {
	$partofday = "õppimise aeg";
}
if($hournow >= 18 and $hournow < 22){
        $partofday = "õhtuste toimetuste aeg";
}
if($hournow >= 22){
    $partofday = "päeva kokkuvõtte ning magamamineku aeg";
}
    
    
    
    

//jälgime semestri kulgu 
$semesterstart = new DateTime("2020-8-31");
$semesterend = new DateTime("2020-12-13");
$semesterduration = $semesterstart->diff($semesterend);
$semesterdurationdays = $semesterduration->format("%r%a");
$today = new DateTime("now");
$fromsemesterstart = $semesterstart->diff($today);
//saime aja erinevuse objektina, seda niisama näidata ei saa
$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
$semesterpercentage = 0;

$semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
if($semesterstart > $today){
        $semesterinfo = "Semester pole veel peale hakanud!";
    }
if($fromsemesterstartdays === 0){
        $semesterinfo = "Semester algab täna!";
    }
 if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
        $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
        $semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
    }
 if($fromsemesterstartdays == $semesterdurationdays){
        $semesterinfo = "Semester lõppeb täna!";
    }
 if($fromsemesterstartdays > $semesterdurationdays){
        $semesterinfo = "Semester on läbi saanud!";
    }

//loen kataloogist piltide nimekirja
//$allfiles = scandir("../vp_pics/");
$allfiles = array_slice(scandir("../vp_pics/"), 2);
//echo $allfiles; //massiivi nii näidata ei saa!!!!
//var_dump($allfiles);
//$allpicfiles = array_slice($allfiles, 2);
//var_dump($allpicfiles);
$allpicfiles = [];
$picfiletypes = ["image/jpeg", "image/png"];
//käin kogu massiivi läbi ja kontrollin iga üksikut elementi, kas on sobiv fail ehk pilt
foreach ($allfiles as $file){
	$fileinfo = getImagesize("../vp_pics/" .$file);
	if(in_array($fileinfo["mime"], $picfiletypes) == true){
		array_push($allpicfiles, $file);	
	}
		}
//paneme kõik pildid järjest ekraanile
//uurime, mitu pilti on ehk mitu faili on nimekirjas - massiivis
$piccount = count($allpicfiles);
$picnum = mt_rand(0, ($piccount - 1));
//$i = $i + 1;
//$i += 1;
//$i ++;
$imghtml = "";
//for($i = 0; $i < $piccount; $i ++){
	//<img src="../img/vp_banner.png" alt="alt tekst">
    $imghtml .= '<img src="../vp_pics/' .$allpicfiles[$picnum] .'" ';
    $imghtml .= 'alt="Tallinna Ülikool">';


require("header.php");
?>



<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdayNamesET [$weekdaynow - 1] .", ". $daynow . " " .$monthNamesET[$monthnow - 1] . " " . $yearnow.", kell on " .$timenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>.
<ul>
     <li><a href = "nonsens.php">Siia saad sisestada oma mõtetu mõtte!</a></li>
     <li><a href="answers.php">Siit saad vaadata oma sisestatud mõtetuid mõtteid!</a></li>
     <li><a href="listfilms.php">Filmiinfo näitamine</a></li>
     <li><a href="addfilms.php">Filmiinfo lisamine</a></li>
     <li><a href="kasutajad.php">Kasutaja lisamine</a></li>
    </ul>
<?php echo "Parajasti on " .$partofday ."."; ?></p>
  <hr>
  <?php echo $imghtml; ?>
</body>
</html>
