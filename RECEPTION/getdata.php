<?php


include 'db_connect.php';

//MARK PRESENT____________________
$sql = "SELECT * FROM students";

$pres='[';
$curr_pres=0;
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)){
        $pres = $pres . $row['present'].',';
        $curr_pres+=$row['present'];
    }
}

$pres = substr($pres, 0, -1);
$pres = $pres . ']';

//GET NO. OF VEG __________________________________________
$sql = 'SELECT * FROM students WHERE present=1 AND `food`="Vegeterian"';

$result = mysqli_query($conn, $sql);
$veg_presno=mysqli_num_rows($result);


// //GET NO. OF LEAFLETS __________________________________________
// $sql = 'SELECT * FROM students WHERE present=1 AND Leaflet=1';

// $result = mysqli_query($conn, $sql);
// $leafletno=mysqli_num_rows($result);


//GET PARTICIPATING NAMES____________________
$sql = 'SELECT * FROM students WHERE present=1 AND stochastoliga=1';

$participating_names='[]';

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
  $participating_names='[';
  while ($row = mysqli_fetch_assoc($result)){
      $participating_names = $participating_names . '"'.$row['name'].'",';
  }
  $participating_names = substr($participating_names, 0, -1);
  $participating_names = $participating_names . ']';
}


echo <<<EOD
{"present_array" : $pres,
  "curr_pres" : $curr_pres,
  "veg_presno" : $veg_presno,
  "participating_names" : $participating_names}
EOD;

?>
