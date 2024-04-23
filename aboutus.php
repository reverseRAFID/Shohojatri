<?php
session_start();
include('connection.php');

//logout
include('logout.php');

//remember me
include('remember.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>সহযাত্রী(shohojatri)</title>
    <link rel="icon" href="https://i.postimg.cc/xjpxRp7s/Artboard-3.png" type="image/x-icon">
    <meta name="description" content="split fare, share ride!">
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBK8COgBLhYE1qz3JXNkU5ADwr3W4Hu2_0"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
          /*margin top for myContainer*/
          #myContainer {
              margin-top: 40px;
              height: 100%;
              text-align: center;
              color: white;
          }
          
          /*header size*/
          #myContainer h1{
              font-size: 5em;
          }
          
          .bold{
              font-weight: bold;
          }
          #googleMap{
              background-image: linear-gradient(to bottom, #ffecd2 0%, #fcb69f 100%);
              border-radius: 10px;
              box-shadow: 0 0 5px cyan, 0 0 15px cyan;
              width: 100%;
              height: 30vh;
              margin: 20px auto;
          }
          #glow{
              text-align: center;
              font-size: 1em;
              color: white;
              text-shadow: 0 0 5px cyan, 0 0 5px cyan;
              font-size: 1em;
          }
          .signup{
              margin-top: 20px;
          }
          #spinner{
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
              height: 85px;
              text-align: center;
              margin: auto;
              z-index: 1100;
          }
          #results{
            margin-bottom: 100px;   
          }
          .driver{
            font-size:1.5em;
            text-transform:capitalize;
            text-align: center;
          }
          .price{
            font-size:1.5em;
          }
          .departure, .destination{
            font-size:1.5em;
          }
          .perseat{
            font-size:0.5em;
          }
          .journey{
            text-align:left; 
          }
          .journey2{
            text-align:right; 
          }
          .time{
            margin-top:10px;  
          }
          .telephone{
            margin-top:10px;
          }
          .seatsavailable{
            font-size:0.7em; 
            margin-top:5px;
          }
          .moreinfo{
            text-align:left; 
          }
          .aboutme{
            border-top:1px solid grey;
            margin-top:15px;
            padding-top:5px;
          }
          #message{
            margin-top:20px;
          }
          .journeysummary{
            text-align:left; 
            font-size:1.5em;
          }
          .noresults{
            text-align:center;  
            font-size:1.5em;
          }
          
          .previewing{
              max-width: 100%;
              height: auto;
              border-radius: 50%;
          }
          .previewing2{
              margin: auto;
              height: 20px;
              border-radius: 50%;
          }
          
      
      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
    <?php
    if(isset($_SESSION["user_id"])){
        include("navigationbarconnected.php");
    }else{
        include("navigationbarnotconnected.php");
    }  
    ?>
      <div class="cursor" id="cursor">
        <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
          <g>
            <title>Outer Square</title>
            <rect id="canvas_background" height="32" width="32" y="-1" x="-1"/>
            <g display="none" overflow="visible" y="0" x="0" height="100%" width="100%" id="canvasGrid">
            <rect fill="url(#gridpattern)" stroke-width="0" y="0" x="0" height="100%" width="100%"/>
            </g>
          </g>
          <g>
            <title>Inner Square</title>
            <g stroke="null" id="svg_4">
            <rect stroke="#000" id="svg_1" height="30.08503" width="29.97745" y="-0.0771" x="0.00746" stroke-width="0" fill="#6ef0fd"/>
            <rect stroke="#000" id="svg_3" height="24.06803" width="24.08055" y="2.93141" x="2.94642" stroke-width="0" fill="#15111f"/>
            </g>
            <rect stroke="#6ef0fd" id="svg_5" height="3.06595" width="12.10406" y="12.72462" x="8.72043" stroke-width="0.5" fill="#011115"/>
          </g>
        </svg>
      </div>
    
      <div class="container-fluid" id="myContainer">
          <div class="row">
              <div class="col-md-6 col-md-offset-3">
                    <img src="https://i.postimg.cc/xjpxRp7s/Artboard-3.png" alt="shohojatri logo" style="max-width: 200px; max-height: 200px;">
                  <p id="glow">split fare, share ride!</p>
    <h3 id= "glow">About Us</h3>
    <p>Welcome to Shohojatri, the innovative ride-sharing service that makes your daily life easy and <small id="glow">economical!</small></p>
    <p>With Shohojatri, you can seamlessly share rides with others heading to the same destination while also splitting the fare evenly among all passengers. No more hassle of worrying about covering the full cost of your ride, you can enjoy the convenience of ride-sharing while saving money and reducing your carbon footprint.</p>
    <p><small id="glow">Sign-up!</small>, to experience a smarter way to travel.</p>
    <h3 id= "glow">Contact Us</h3>
    <p>For any queries or feedback, please feel free to contact us at:</p>
    <p>Email:
    <a href="mailto: "> rafidbd9@gmail.com</a>
    </a>
    </p>
    <p id="glow">Follow us on social media:</p>
    <a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook-square fa-3x"></i></a>
    <a href="https://www.twitter.com" target="_blank"><i class="fa fa-twitter-square fa-3x"></i></a>
    <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram fa-3x"></i></a>
    
    <!-- Footer-->
      <!-- <div class="footer">
          <div class="container">
              
          </div>
      </div> -->
      
      <!--Spinner-->
      <div id="spinner">
         <img src='loader' width="64" height="64" />
         <br>Loading..
      </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="map.js"></script>  
    <script src="javascript.js"></script>
    <script src="cursor.js"></script>

  </body>
</html>