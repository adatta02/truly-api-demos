<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>tru.ly Social API Demo</title>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,700&v2' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />    
  </head>
    <body class="body-black">
    
    <div id="main">
            <div class="centered">
            
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): 
                
                	$sig = urldecode( $_REQUEST["signature"] );
                	$data = urldecode( $_REQUEST["data"] );

                	$secret = "9ffd989277b2058efe0542aff08c9301dc9fd9ce";
                	$expected_sig = hash_hmac('sha256', $data, $secret, false);
  					
  					$error = null;
  					if ($sig !== $expected_sig) {
  						$error = "INVALID SIGNATURE!";
  					} ?>
                	
                  <?php if( $error ): ?>
                    
                    <div class="error">
                        <h3>Sorry!</h3>
                        <p>Got an invalid signature!</p>
                    </div>
                  
                  <?php else: 
                  	$data = json_decode( $data, true );
                  ?>
                    
	               	  <?php if( $data["truly_verified"] ): ?>
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
	                            
	                            <p>At this time you can't access the age gated content.</p>
	                       </div>
	                	<?php endif; ?>
                
                    <?php endif; ?>
                
                <?php else: ?>
            
	                <p class="first">You need to be 21+ to access this site.</p> 
	                <p>Please verify your age by completing the form below.</p>
	                
                    <script type="text/javascript" src="https://tru.ly/api-get-js?app_id=521015754515750544897575157&width=100%25&height=360"></script>
                    
                <?php endif; ?>
                
            </div>
    </div>
    
    </body>
</html>