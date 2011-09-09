<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Pear By Absolut</title>
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,700&v2' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />    
  </head>
    <body class="body-black">
    
    <div id="main">
            <div class="centered">
            
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): 
                
                	$data = json_decode( $_REQUEST["registrationData"], true );
                	if( $data["truly_verified"] ): ?>
                        <div class="success centered">
                            <h3>We were able to verify your age.</h3>
                            <table>
                                <tbody>
                                    <?php foreach( $data as $k => $v ): ?>
                                        <tr>
                                            <td><?php echo $k; ?></td>
                                            <td><?php echo $v; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>	
                		
                	<?php else: ?>
                	   <div class="error">
                            <h3>Sorry!</h3>
                            <p>We were unable to verify your age</p>
                            
                            <p>At this time you can't access Absolut Pear.</p>
                       </div>
                	<?php endif; ?>
                
                <?php else: ?>
            
	                <h3>Pear By Absolut</h3>
	                <p>You need to be 21+ to access this site.</p> 
	                <p>Please verify your age by completing the form below.</p>
	                
					<iframe src="https://www.facebook.com/plugins/registration.php?
					             client_id=165036850194823&fb_only=true&
					             redirect_uri=http%3A%2F%2Fr3.tru.ly%2Ffb-age-verify%3Freturn_to%3Dhttp%3A%2F%2Fapi.tru.ly%2Fageverify%2F&
					             fields=%5B%0A%20%7B'name'%3A'name'%7D%2C%0A%20%7B'name'%3A'last_name'%7D%2C%0A%20%7B'name'%3A'email'%7D%2C%0A%20%7B'name'%3A'birthday'%7D%2C%0A%20%7B'name'%3A'zip_code'%2C%20%20%20%20%20%20'description'%3A'Your%20permanent%20zip%20code'%2C%20%20%20%20%20%20%20%20%20%20%20%20%20'type'%3A'text'%7D%2C%0A%5D
					        " scrolling="auto"
					        frameborder="no"
					        style="border:none"
					        allowTransparency="true"
					        width="100%"
					        height="330">
					</iframe>
                
                <?php endif; ?>
                
            </div>
    </div>
    
    </body>
</html>