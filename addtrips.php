<?php
//start session and connect
session_start();
include('connection.php');

//define error messages
$missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';
$missingprice = '<p><strong>Please choose a price per seat!</strong></p>';
$invalidprice = '<p><strong>Please choose a valid price per seat using numbers only!!</strong></p>';
$missingseatsavailable = '<p><strong>Please select the number of available seats!</strong></p>';
$invalidseatsavailable = '<p><strong>The number of available seats should contain digits only!</strong></p>';
$missingfrequency = '<p><strong>Please select a frequency!</strong></p>';
$missingdays = '<p><strong>Please select at least one weekday!</strong></p>';
$missingdate = '<p><strong>Please choose a date for your trip!</strong></p>';
$missingtime = '<p><strong>Please choose a time for your trip!</strong></p>';
$splitfare = '<p><strong>Please choose splitting amount!</strong></p>';

//Get inputs:
$departure = array_key_exists("departure",$_POST) ? $_POST["departure"] : null;
$destination = array_key_exists("destination",$_POST) ? $_POST["destination"] : null;
$price = array_key_exists("price",$_POST) ? $_POST["price"] : null;
$seatsavailable = array_key_exists("seatsavailable",$_POST) ? $_POST["seatsavailable"] : null;
$regular = array_key_exists("regular",$_POST) ? $_POST["regular"] : null;
$date = array_key_exists("date",$_POST) ? $_POST["date"] : null;
$time = array_key_exists("time",$_POST) ? $_POST["time"] : null;
$monday = array_key_exists("monday",$_POST) ? $_POST["monday"] : null;
$tuesday = array_key_exists("tuesday",$_POST) ? $_POST["tuesday"] : null;
$wednesday = array_key_exists("wednesday",$_POST) ? $_POST["wednesday"] : null;
$thursday = array_key_exists("thursday",$_POST) ? $_POST["thursday"] : null;
$friday = array_key_exists("friday",$_POST) ? $_POST["friday"] : null;
$saturday = array_key_exists("saturday",$_POST) ? $_POST["saturday"] : null;
$sunday = array_key_exists("sunday",$_POST) ? $_POST["sunday"] : null;
$splitfare = array_key_exists("splitfare",$_POST) ? $_POST["splitfare"] : null;
$errors = "";

//check coordinates
if(!isset($_POST["departureLatitude"]) or !isset($_POST["departureLongitude"])){
    $errors .= $invaliddeparture;   
}else{
    $departureLatitude = $_POST["departureLatitude"];
    $departureLongitude = $_POST["departureLongitude"];
}

if(!isset($_POST["destinationLatitude"]) or !isset($_POST["destinationLongitude"])){
    $errors .= $invaliddestination;   
}else{
    $destinationLatitude = $_POST["destinationLatitude"];
    $destinationLongitude = $_POST["destinationLongitude"];
}


//Check departure:
if(!$departure){
    $errors .= $missingdeparture;   
}else{
    $departure = filter_var($departure, FILTER_SANITIZE_STRING); 
}

//Check destination:
if(!$destination){
    $errors .= $missingdestination;   
}else{
    $destination = filter_var($destination, FILTER_SANITIZE_STRING); 
}

//Check Price
if(!$price){
    $errors .= $missingprice; 
}elseif(preg_match('/\D/', $price)  // you can use ctype_digit($price)
){
        $errors .= $invalidprice;   
}else{
    $price = filter_var($price, FILTER_SANITIZE_STRING);    
}

// add the amount to be split
if(!$splitfare){
    $errors .= $splitfare;
}else{
    $splitfare = filter_var($splitfare, FILTER_SANITIZE_STRING);
}

//Check Seats Available
if(!$seatsavailable){
    $errors .= $missingseatsavailable; 
}elseif(preg_match('/\D/', $seatsavailable)  // you can use ctype_digit($seatsavailable)
){
        $errors .= $invalidseatsavailable;   
}else{
    $seatsavailable = filter_var($seatsavailable, FILTER_SANITIZE_STRING);    
}

//Check regular
if(!$regular){
    $errors .= $missingfrequency;    
}elseif($regular == "Y"){
    if(!$monday && !$tuesday && !$wednesday && !$thursday && !$friday && !$saturday && !$sunday ){
        $errors .= $missingdays; 
    }
    if(!$time){
        $errors .= $missingtime;   
    }
}elseif($regular == "N"){
    if(!$date){
        $errors.= $missingdate;   
    }
    if(!$time){
        $errors .= $missingtime;   
    }
}

// if there is an error print error message
if($errors != ""){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;

}
else{
    //no errors, prepare variables for the query
    $tbl_name = 'carsharetrips';
    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);

    if($regular == "Y"){
        //query for a regular trip
        $sql = "INSERT INTO $tbl_name (`user_id`,`departure`, `departureLongitude`, `departureLatitude`, `destination`, `destinationLongitude`, `destinationLatitude`, `price`,`splitfare`, `seatsavailable`, `regular`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`, `time`) VALUES ('".$_SESSION['user_id']."', '$departure','$departureLongitude','$departureLatitude','$destination','$destinationLongitude','$destinationLatitude','$price', '$splitfare', '$seatsavailable','$regular','$monday','$tuesday','$wednesday','$thursday','$friday','$saturday','$sunday','$time')";
    }else{ 
        //query for a one off trip
        $sql = "INSERT INTO $tbl_name (`user_id`,`departure`, `departureLongitude`, `departureLatitude`, `destination`, `destinationLongitude`, `destinationLatitude`, `price`, `splitfare`, `seatsavailable`, `regular`, `date`, `time`) VALUES ('".$_SESSION['user_id']."', '$departure','$departureLongitude','$departureLatitude','$destination','$destinationLongitude','$destinationLatitude','$price', '$splitfare', '$seatsavailable','$regular','$date','$time')";   
    }
    $results = mysqli_query($link, $sql);
    //check if query is successful
    if(!$results){
        echo '<div class=" alert alert-danger">There was an error! The trip could not be added to database!</div>';        
    }
}

?>