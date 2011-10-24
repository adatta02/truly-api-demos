<?php 

/*
 * This file kicks of the OpenID transaction.
 * ashish@tru.ly
 */

require_once 'common.php';
error_reporting(0);

// boilerplate to bootstrap the OpenID transaction

$openid = TRULY_URL;
$consumer = getConsumer( );
$auth_request = $consumer->begin($openid);
if (!$auth_request) { die("Authentication error; not a valid OpenID."); }

// define what attribute we want returned from us via Attribute Exchage

/*
 * Valid Attribute Exchange (AX) URIs:
 *  http://axschema.tru.ly/contact/first
 *  http://axschema.tru.ly/contact/last
 *  http://axschema.tru.ly/contact/email
 *  http://axschema.tru.ly/contact/birthday
 *  http://axschema.tru.ly/contact/age
 *  http://axschema.tru.ly/contact/birthday
 *  http://axschema.tru.ly/contact/address
 *  http://axschema.tru.ly/contact/state
 *  http://axschema.tru.ly/contact/city
 *  http://axschema.tru.ly/contact/is_verified - this one is returned automatically
*/

$ax_attribute = array( );
$ax_attribute[] = Auth_OpenID_AX_AttrInfo::make( "http://axschema.tru.ly/contact/first", 1, 1 );
$ax_attribute[] = Auth_OpenID_AX_AttrInfo::make( "http://axschema.tru.ly/contact/last", 1, 1 );
$ax_attribute[] = Auth_OpenID_AX_AttrInfo::make( "http://axschema.tru.ly/contact/email", 1, 1 );
$ax_attribute[] = Auth_OpenID_AX_AttrInfo::make( "http://axschema.tru.ly/contact/birthday", 1, 1 );
$ax_attribute[] = Auth_OpenID_AX_AttrInfo::make( "http://axschema.tru.ly/contact/age", 1, 1 );


// build the AX request
$ax = new Auth_OpenID_AX_FetchRequest();
foreach($ax_attribute as $attr){  $ax->add($attr);  }
$auth_request->addExtension($ax);

// add the popup extension to let tru.ly know how to render the form
if( $_REQUEST["popup"] ){
	$auth_request->addExtensionArg( "http://specs.openid.net/extensions/ui/1.0", "mode", "popup" );
}

/* 
 * -- tru.ly specific extension --
 * These are UI extensions that allow you to pass additional information to appear above the verification form.
 * They should be your company name, a logo, and the reason you're requesting the user to verify
*/
$auth_request->addExtensionArg( "http://specs.openid.net/extensions/ui/1.0", "name", "Acme Co." );
$auth_request->addExtensionArg( "http://specs.openid.net/extensions/ui/1.0", "logo", "http://api.tru.ly/enterprise/radioactive.jpeg" );
$auth_request->addExtensionArg( "http://specs.openid.net/extensions/ui/1.0", "blurb", "Acme Co. would like you to verify your identity to ensure that you are old enough to access Acme Co. content." );

/*
 * -- tru.ly specific extenion --
 * This extension allows you to pass information into the form to pre-fill it with information you all ready have about the user
 * Each key will set the value of a different form field
 * Valid form fill keys:
 *  email
 *  first_name
 *  last_name
 *  street_address
 *  zip
 *  birthday (must be formatted YEAR-MONTH-DAY with '-' as the seperator)
*/ 

if( array_key_exists("form", $_REQUEST) ){
	foreach( $_REQUEST["form"] as $key => $val ){
		$auth_request->addExtensionArg( "http://specs.tru.ly/extensions/form-fill/1.0", $key, $val );
	}
}

// figure out how to redirect the user and then send them on their way
if ($auth_request->shouldSendRedirect()) {
	
	$redirect_url = $auth_request->redirectURL(getTrustRoot(), getReturnTo());
	
	if (Auth_OpenID::isFailure($redirect_url)) {
		die("Could not redirect to server: " . $redirect_url->message);
	} else {
		header("Location: ".$redirect_url);
	}
	
} else {
  
	$form_id = 'openid_message';
	$form_html = $auth_request->htmlMarkup(getTrustRoot(), getReturnTo(), false, array('id' => $form_id));

	if (Auth_OpenID::isFailure($form_html)) {
		die("Could not redirect to server: " . $form_html->message);
	} else {
		print $form_html;
	}
	
}