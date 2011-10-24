<?php 
require_once 'common.php'; 
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>tru.ly API Demo</title>
<link media="screen" rel="stylesheet" href="style/screen.css" />
<link media="screen" rel="stylesheet" href="style/colorbox.css" />
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery.colorbox-min.js"></script>
</head>
<body>

<script type="text/javascript">

    $(document).ready( function(){
 
        $(".colorbox").colorbox( {iframe: true, innerWidth:425, innerHeight:344} );
        
        $("#authForm").submit( function(){
            $.colorbox( {iframe: true, innerWidth: 560, innerHeight:800, href: "auth.php?popup=true&" + $("#authForm").serialize()} );
            return false;
        });

        $("#verifyBtn").click( function(){
        	$("#authForm").submit();
        	return false;
        });
        
    });

    function recieveData( payload ){
 
      $.colorbox.close();

      $(".error, .success").hide();
      
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

<div class="span-14 prepend-6" style="padding-top: 100px">
<h1>Sign up for Acme Co.</h1>

<form id="authForm" method="post">
<table>
	<tbody>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="form[first_name]" /></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="form[last_name]" /></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><input type="email" name="form[email]" /></td>
		</tr>
	</tbody>
</table>

<div class="success" style="display: none; padding-top: 10px; padding-bottom: 10px">Verification succesfull!</div>

<div class="error" style="display: none; padding-top: 10px; padding-bottom: 10px">

</div>

<div class="span-9">
<p>Acme Co. uses tru.ly to verify your information in order to verify
that you are old enough to access Acme Co.</p>
<p>You will have to verify your age before you can access our site.</p>
</div>

<div class="span-5 last"><a href="#" id="verifyBtn"><img
	src="verify.png" style="width: 180px" /></a> <input type="submit"
	style="display: none" /></div>

<div class="clear"></div>
</form>

</div>

</div>

</body>
</html>