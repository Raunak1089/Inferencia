<?php

include 'index.php';

$regID = $_POST['regID'];

include 'db_connect.php';

$sql = "SELECT * FROM participants WHERE `RegID` = '$regID';";
$res='';
$lunch_taken=False;
$pres=False;

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)){
        $res = $res . 'regID: '.$row['RegID'];
        $res = $res . '<br>Name: '.$row['sName'];
        $res = $res . '<br>College: '.$row['College_name'];
        $res = $res . '<br>Dept: '.$row['Dept'];
        $res = $res . '<br>Present: '.$row['Present'];
        if($row['Present']==True) {$pres=True;}
        $res = $res . '<br>Lunch taken: '.$row['Lunch'];
        if($row['Lunch']==True) {$lunch_taken=True;}
    }

    if($lunch_taken) {echo '<script>document.querySelector("#details").innerHTML+=`<h2 style="color:red">Lunch already taken!</h2>`</script>';}
    else if(!$lunch_taken and $pres){
        $sql2 = "UPDATE `participants` SET `Lunch` = True WHERE `RegID` = '$regID';";
        mysqli_query($conn, $sql2);
        $lunch_taken=True;
        echo '<script>document.querySelector("#details").innerHTML+=`<h2 style="color:lime">Have a good lunch time!</h2>`</script>';
    }
    else {
        echo '<script>document.querySelector("#details").innerHTML+=`<h2>This person is not a present attendant!</h2>`</script>';
    }
}
else {
    echo '<script>document.querySelector("#details").innerHTML+=`Sorry, this person is not registered in our database!`</script>';
}




echo '<script>document.querySelector("#details").innerHTML+=`<h2>Person Details:</h2>`</script>';
echo '<script>document.querySelector("#details").innerHTML+=`'.$res.'`</script>';

mysqli_close($conn);
?>
