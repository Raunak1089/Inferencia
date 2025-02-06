<?php

include 'index.php';

$regId = $_POST['regId'];

include 'db_connect.php';


$sql = "SELECT * FROM students WHERE `regId` = '$regId';";

$res='<table>';
$food='';
$stochastoliga='';
$ispres='';

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)){
        // $res = $res . 'regId: '.$row['regId'];
        $res = $res . '<tr><td>S.No: </td><td>'.$row['sno'].'</td></tr>';
        $res = $res . '<tr><td>Name: </td><td>'.$row['name'].'</td></tr>';
        $res = $res . '<tr><td>College: </td><td>'.$row['college'].'</td></tr>';
        $res = $res . '<tr><td>Year: </td><td>'.$row['year'].'</td></tr>'; 
        if($row['food']=="Non-Vegeterian") {$food=False;} else {$food=True;}
        if($row['stochastoliga']) {$stochastoliga=True;} else {$stochastoliga=False;}
        if($row['present']) {$ispres=True;} else {$ispres=False;}
    }
    $res = $res . '</table>';

if(!$ispres){
    $sql = "UPDATE `students` SET `present` = True WHERE `regId` = '$regId';";
    mysqli_query($conn, $sql);

    echo '<script>document.querySelector("#details").innerHTML="<h2>Welcome to RKMRC!</h2>"</script>';
    echo '<script>document.querySelector("#details").innerHTML+="<h2>Student Details:</h2>"</script>';
    echo '<script>document.querySelector("#details").innerHTML+="'.$res.'"</script>';
    echo '<script>document.querySelector("#details").innerHTML+=`<div id="icons" style="display:flex;align-items:center;"></div>`</script>';
    
    if($food){
        echo '<script>document.querySelector("#icons").innerHTML+=`<img style="position: relative;" src="images/veg.svg">`</script>';
    } else {
        echo '<script>document.querySelector("#icons").innerHTML+=`<img style="position: relative;" src="images/nonveg.svg">`</script>';
    }
    
    if($stochastoliga){
        echo '<script>document.querySelector("#icons").innerHTML+=`<img style="position: relative; width: 50; height: 50;" src="images/liga.png">`</script>';
    // } else {
    //     echo '<script>document.querySelector("#icons").innerHTML+=`<i style="color: red; font-size: 2em;" class="fa-regular fa-xmark"></i>`</script>';
    }
    
    // if($leaflet){
    //     echo '<script>document.querySelector("#icons").innerHTML+=`<img style="position: relative; width: 50; height: 50;" src="images/leaflet.png">`</script>';
    // // } else {
    // //     echo '<script>document.querySelector("#icons").innerHTML+=`<i style="color: red; font-size: 2em;" class="fa-regular fa-xmark"></i>`</script>';
    // }
    
    mysqli_close($conn);
    

} else {
    echo '<script>document.querySelector("#details").innerHTML="Sorry, this person is already present in the fest!"</script>';
}




}
else {
    echo '<script>document.querySelector("#details").innerHTML="Sorry, this person is not registered in our database!"</script>';
}

?>

