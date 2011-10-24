<?php

/*
 * This file finishes up the OpenID transaction
 * ashish@tru.ly
 */

require_once 'common.php';

// finish it up
$consumer = getConsumer();
$return_to = getReturnTo();
$response = $consumer->complete($return_to);

// this will get passed back to the parent window
$openIDStatus = array( 
	"status" => $response->status,
	"ax_data" => array()
);

// see what happened
if ($response->status == Auth_OpenID_CANCEL) { // auth was cancelled
	
  $openIDStatus["msg"] = 'Verification cancelled.';
	
} else if ($response->status == Auth_OpenID_FAILURE) { // auth failed
  
	$openIDStatus["msg"] = "OpenID authentication failed: " . $response->message;
	
} else if ($response->status == Auth_OpenID_SUCCESS) { // auth was succesfull - pull out the info
	
	$openid = $response->getDisplayIdentifier();
	$esc_identity = htmlentities($openid);
	$openIDStatus["uri"] =  $esc_identity;

	// pull out the AX data 
	$ax = Auth_OpenID_AX_FetchResponse::fromSuccessResponse( $response, true );
	foreach( $ax->data as $uri => $val ){
		$openIDStatus["ax_data"][ $uri ] = array_pop( $val );
	}
	
}

?>

<script type="text/javascript">

// pass the result back to the parent
if( window.parent ){
    window.parent.recieveData( <?php echo json_encode($openIDStatus); ?> );
}

</script>