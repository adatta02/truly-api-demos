<?php 
require_once 'common.php'; 
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>tru.ly iframe API Demo</title>
<link media="screen" rel="stylesheet" href="style/screen.css" />
<link media="screen" rel="stylesheet" href="style/colorbox.css" />
<script type="text/javascript"
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery.colorbox-min.js"></script>
</head>
<body>

<script type="text/javascript">

    function recieveData( payload ){
 
      $(".error, .success, #trulyIframe").hide();
      
      if( payload.status == "<?php echo Auth_OpenID_CANCEL; ?>" ){ // they cancelled the request
          $(".error").html("Sorry! You can not cancel the verification request.");
          $(".error").slideDown( 800 );
      }else if( payload.status == "<?php echo Auth_OpenID_FAILURE; ?>" ){ // there was some openid error
          $(".error").html("There was a fatal OpenID error: " + payload.msg);
          $(".error").slideDown( 800 );
      }else if( payload.status == "<?php echo Auth_OpenID_SUCCESS; ?>" ){ // they came back, need to check if they verified

          if( payload['ax_data']['http://axschema.tru.ly/contact/is_verified'] ){
            $(".success").html("Success! We verified that you are " 
                  + payload['ax_data']['http://axschema.tru.ly/contact/age'] + " years old!" );
            $(".success").slideDown( 800 );
          }else{
            $(".error").html("Sorry! Because you were unable to verify you can not register with with us.");
            $(".error").slideDown( 800 );
          }
          
      }
      
    }

</script>

<div class="container">

  <div class="span-15 prepend-6" style="padding-top: 100px">
    
    <h1>Sign up for Acme Co.</h1>
  
    <p>Acme Co. uses tru.ly to verify your information in order to verify 
      that you are old enough to access Acme Co.</p>
    <div style="text-align: center">
      <p><strong>You will have to verify your age before you can access our site.</strong></p>
    </div>
    
    <iframe id="trulyIframe" width="590" height="1000" src="auth.php?popup=true"></iframe>
    
    <div class="success" style="display: none; padding-top: 10px; padding-bottom: 10px">Verification succesfull!</div>
  
    <div class="error" style="display: none; padding-top: 10px; padding-bottom: 10px">
  
  </div>
  
  <div class="clear"></div>
  
  </div>

</div>

</body>
</html>