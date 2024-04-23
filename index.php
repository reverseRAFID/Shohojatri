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
          <!-- Created with Method Draw - http://github.com/duopixel/Method-Draw/ -->
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

                  <!--Search Form-->
                  <form class="form-inline" method="get" id="searchform">
                      <div class="form-group">
                          <label class="sr-only" for="departure">Departure:</label>
                          <input type="text" class="form-control" id="departure" placeholder="Departure" name="departure">
                      </div>
                      <div class="form-group">
                          <label class="sr-only"></label>
                          <input type="text" class="form-control" id="destination" placeholder="Destination" name="destination">
                      </div>
                      <input type="submit" value="Search" class="btn btn-lg green" name="search">
                  
                  </form>
                  <!--Search Form End-->
                  
                  <!--Google Map-->
                  <div id="googleMap"></div>
                  
                  <!--Sign up button-->
                  <?php
                  if(!isset($_SESSION["user_id"])){
                      echo '<button type="button" class="btn btn-lg green signup" data-toggle="modal" data-target="#signupModal">Sign up!</button>';
                  }
                  ?>
                  <div id="results">
                    <!--will be filled with Ajax Call-->
                </div>
              
              </div>
          
          </div>
      
      </div>

    <!--Login form-->    
      <form method="post" id="loginform" >
        <div class="modal"  style="margin-top: 100px;" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel" class = "text-light">
                    Login: 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Login message from PHP file-->
                  <div id="loginmessage"></div>
                  

                  <div class="form-group">
                      <label for="loginemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="loginpassword" class="sr-only">Password</label>
                      <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="30">
                  </div>
                  <div class="checkbox">
                      <label>
                          <input type="checkbox" name="rememberme" id="rememberme">
                        Remember me
                      </label>
                          <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">
                      Forgot Password?
                      </a>
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="login" type="submit" value="Login">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="signupModal" data-toggle="modal">
                  Register
                </button>  
              </div>
          </div>
      </div>
      </div>
      </form>

    <!--Sign up form--> 
      <form method="post" id="signupform">
        <div class="modal" style="margin-top: 100px;" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Sign up and get started! 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Sign up message from PHP file-->
                  <div id="signupmessage"></div>
                  
                  <div class="form-group">
                      <label for="username" class="sr-only">Username:</label>
                      <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="firstname" class="sr-only">Firstname:</label>
                      <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Firstname" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="lastname" class="sr-only">Lastname:</label>
                      <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Lastname" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="email" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="password" class="sr-only">Choose a password:</label>
                      <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="password2" class="sr-only">Confirm password</label>
                      <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="30">
                  </div>
                  <div class="form-group">
                      <label for="phonenumber" class="sr-only">Telephone:</label>
                      <input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Telephone Number" maxlength="15">
                  </div>
                  <div class="form-group">
                      <label><input type="radio" name="gender" id="male" value="male">Male</label>
                      <label><input type="radio" name="gender" id="female" value="female">Female</label>
                  </div>
                  <div class="form-group">
                      <label for="moreinformation">About me(note: This info would be visible to public): </label>
                      <textarea name="moreinformation" class="form-control" rows="5" maxlength="300"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="signup" type="submit" value="Sign up">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
              </div>
          </div>
      </div>
      </div>
      </form>

    <!--Forgot password form-->
      <form method="post" id="forgotpasswordform">
        <div class="modal" style="margin-top: 100px;" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Forgot Password? Enter your email address: 
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--forgot password message from PHP file-->
                  <div id="forgotpasswordmessage"></div>
                  

                  <div class="form-group">
                      <label for="forgotemail" class="sr-only">Email:</label>
                      <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50">
                  </div>
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="forgotpassword" type="submit" value="Submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="signupModal" data-toggle="modal">
                  Register
                </button>  
              </div>
          </div>
      </div>
      </div>
      </form>
    <!-- Footer-->
      <div class="footer">
          <div class="container">
              
          </div>
      </div>
      
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