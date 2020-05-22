<?php
session_start();
include('config.php');
include('hybridauth/Hybrid/Auth.php');
if(isset($_GET['provider']))
{
$provider = $_GET['provider'];
try{
    $hybridauth = new Hybrid_Auth( $config );
    $authProvider = $hybridauth->authenticate($provider);
    $user_profile = $authProvider->getUserProfile();
    if($user_profile && isset($user_profile->identifier))
    {
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        
        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><?php echo $user_profile->displayName."<br>";?></a></li>
            <li><a href="#"><?php echo $user_profile->email."<br>";?></a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container homepage">
      <div class="row">
         <div class="col-md-3"></div>
            <div class="col-md-6 welcome-page">
              <h2>Physician Dashboard.</h2>
            </div>
          <div class="col-md-3"></div>
        </div>
    </div>  

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>

<?php
        
       // echo "<b>Profile URL</b> :".$user_profile->profileURL."<br>";
       // echo "<b>Image</b> :".$user_profile->photoURL."<br> ";
        //echo "<img src='".$user_profile->photoURL."'/><br>";
       // echo "<b>Email</b> :".$user_profile->email."<br>";
       // echo "<br> <a href='logout.php'>Logout</a>";

    }           
 
    }
    catch( Exception $e )
    { 
         switch( $e->getCode() )
         {
                case 0 : echo "Unspecified error."; break;
                case 1 : echo "Hybridauth configuration error."; break;
                case 2 : echo "Provider not properly configured."; break;
                case 3 : echo "Unknown or disabled provider."; break;
                case 4 : echo "Missing provider application credentials."; break;
                case 5 : echo "Authentication failed The user has canceled the authentication or the provider refused the connection.";
                         break;
                case 6 : echo "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                         $authProvider->logout();
                         break;
                case 7 : echo "User not connected to the provider.";
                         $authProvider->logout();
                         break;
                case 8 : echo "Provider does not support this feature."; break;
        }
 
        echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
 
        echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";
 
    }
 
}
?>