<?php

	function logLoginAttempt($lMessage){
		try {
			global $LogHandler;
			$LogHandler->writeToLog($lMessage);
		} catch (Exception $e) {
			/*do nothing*/
		};
	};//end function logLoginAttempt

    try {
		$lQueryString = "";
    	switch ($_SESSION["security-level"]){
	   		case "0": // This code is insecure
	   		case "1": // This code is insecure
				/*
				 * Grab username and password from parameters.
				 * Notice in insecure mode, we take parameters from "REQUEST" which
				 * could be GET OR POST. This is not correct. The page
				 * intends to receive parameters from POST and should
				 * restrict parameters to POST only.
				 */
				$lUsername = $_REQUEST["username"];
				$lPassword = $_REQUEST["password"];
	   			$lProtectCookies = FALSE;
	   			$lConfidentialityRequired = FALSE;
	   		break;

			case "2":
			case "3":
			case "4":
	   		case "5": // This code is fairly secure
	   			/* Restrict paramters to POST */
				$lUsername = $_POST["username"];
				$lPassword = $_POST["password"];
	   			$lProtectCookies = TRUE;
	   			$lConfidentialityRequired = TRUE;
	   		break;
	   	}// end switch

	   	$cUNSURE = -1;
	   	$cACCOUNT_DOES_NOT_EXIST = 0;
	   	$cPASSWORD_INCORRECT = 1;
	   	$cNO_RESULTS_FOUND = 2;
	   	$cAUTHENTICATION_SUCCESSFUL = 3;
	   	$cAUTHENTICATION_EXCEPTION_OCCURED = 4;
	   	$cUSERNAME_OR_PASSWORD_INCORRECT = 5;

	   	$lAuthenticationAttemptResult = $cUNSURE;
	   	$lAuthenticationAttemptResultFound = FALSE;
	   	$lKeepGoing = TRUE;
	   	$lQueryResult=NULL;
    $pk = '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAuKdGuN/7m+G2zJDzv6JV55ntvK4hXYpq/xD1DOpypHan5rOY
u9v/1DLUYDLm6BrUD2VeiBg+BftlPOqmadZvLjlF/QpgfKwZuznxIs94w0gyHqXK
doikg82mb8M4IZGt7GJeybAaXha7jVfXHohHR5BYO/g5DTMj+P2QgiJ5sNKPNAbB
LVsjR5S0/vDud9TqigaEPHEZagPkduJKoGNZiQrR8EoP6uulAMpJLjM0BnQuryko
Oz076HG1CR3gz+dGmA7+QAU+KB9p7iEr8+tUzkTpvD3gQbHy6Fda2Q1/8uNteKNs
ARg2/QiWjGpd1Pjcz+uAA95+HV3w3V3wnWKeDwIDAQABAoIBABTzhea8I0RQm/ki
CUYZGT4qDPt3lnmSlwlR1zwb7d4TSIG4pv/JuoFNMyOnIuP7B0yn583xUjhDif0b
cr5Xgk3wWayYXNJIhLLlpCKa/8zIiEdJ8Gr6nhAGaXgM4nWMnftQPgkMXjGGyskC
ynnAZLYN/rTvOSnyP4ak3pylZMFXMWmf0YXBpQKzJeadoYLO+p0plK+uHPxXzv+8
07/kk4NQpCkL/yUv9Umondlq3ZD3oo2at/TdAaYxi0qg5/mda+1n1a98g73q5RP8
zfe39paYzpKqzODMMkiLxIgdyxL0lu+oGVMuWoQxwrTrxTiZP+KPKK65z5oVdnT6
AWe6uCECgYEA2iTkk/4Bk5DIdjIpOUu+61zg1krS9LnZAA/C1xB05BXPsHtGF5Ig
BHn7n9oBWbih59qtF+H48rpxM4smdiUhTGWIcpIMGXUFumabQlfzJUnFUTeOk2wm
UVez6heXkFf0lB2+8EVRZg026ehPTgYLkrYy04vYVg8sUUzySx+k6tsCgYEA2LKN
EVBKdLYalKtVRIL2jN+cUgyDISkvmNEG0briouXMkaGgrPrFe5CoHrlixjRN0VJx
rpcQjwaB5pBpoALb0eOgd1J1hUmGX0ipyYFTROl1o/dZP32DQzWK5CjMuFu8hTTr
Dz55FxST4ZEERB/zvr8BImuLYMuBnQBcjeIgTd0CgYB+XnLf3HxzTKMj/WjuHRgL
ZnGFEjFkvaicpYS8a3cbjhsTZEY1b1wG29dNQdAYdqGsG3y8YhaCHklnj4uHU3kX
tZW2sS47LRRVaA03AJYFGtgodWOtuS/1XTYHPQV7A8jWaOjsbWt7D9qo4//U9iGM
KuoErHV1XTLSIh4WMM2rkwKBgQCrDSY1iH99aVHKEQSZtBcSVGB8k8venTgpFLah
TzgfBe5Y9pByevDv/Nv4hLXnZtoWZVG/UxeLDsPzUANQf3EtWNUN21VRBRzAkgcU
PLWSLAbkixcz+stmfhlIyLvwutkw/Pifa90Bzwh8gZAwhlhNNVCb7vByU7HYULS+
esStMQKBgCpzInEy/CZS5SWrMmqp45Bh1FFWmXvDppa023qDbX6Y/b7r7beA9Xux
BYTaSywD0Nd3ZUkZz1k+2cYkR6tc3VVAc8wTjyxTYwQF4Y3XNoreB4zXPLAp4TEL
Q7FEYN4qc1yIR6EZFF76b27rkgzKVkywRuw+adjUxiu65u9hyFow
-----END RSA PRIVATE KEY-----
';
      $decrypted_user = '';
      openssl_private_decrypt(base64_decode($lUsername), $decrypted_user, $pk);
      $lUsername=$decrypted_user;
      $decrypted_pass = '';
      openssl_private_decrypt(base64_decode($lPassword), $decrypted_pass, $pk);
      $lPassword=$decrypted_pass;

   		logLoginAttempt("User {$lUsername} attempting to authenticate");
      $r = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
      $apc_key = "{$r}~login:{$_SERVER['REMOTE_ADDR']}";
      $resultLogin = $SQLQueryHandler->verifyLoginTries($apc_key);
      if(!$resultLogin){
        $lAuthenticationAttemptResult =6;
      }

   		if (!$SQLQueryHandler->accountExists($lUsername) && $resultLogin){
   		    if ($lConfidentialityRequired){
   		        $lAuthenticationAttemptResult = $cUSERNAME_OR_PASSWORD_INCORRECT;
   		    }else{
   		        $lAuthenticationAttemptResult = $cACCOUNT_DOES_NOT_EXIST;
   		    }// end if
   			$lKeepGoing = FALSE;
   			logLoginAttempt("Login Failed: Account {$lUsername} does not exist");
   		}// end if accountExists

		if ($lKeepGoing && $resultLogin){
   			if (!$SQLQueryHandler->authenticateAccount($lUsername, $lPassword)){
   			    if ($lConfidentialityRequired){
   			        $lAuthenticationAttemptResult = $cUSERNAME_OR_PASSWORD_INCORRECT;
   			    }else{
   			        $lAuthenticationAttemptResult = $cPASSWORD_INCORRECT;
   			    }// end if
	   			$lKeepGoing = FALSE;
	   			logLoginAttempt("Login Failed: Password for {$lUsername} incorrect");
	   		}//end if authenticateAccount
   		}//end if $lKeepGoing

      if($resultLogin){
		$lQueryResult = $SQLQueryHandler->getUserAccount($lUsername, $lPassword);
      }

		if (isset($lQueryResult->num_rows)){
   			if ($lQueryResult->num_rows > 0) {
	   			$lAuthenticationAttemptResultFound = TRUE;
   			}//end if
		}//end if

		if ($lAuthenticationAttemptResultFound){
			$lRecord = $lQueryResult->fetch_object();
			$_SESSION['loggedin'] = 'True';
			$_SESSION['uid'] = $lRecord->cid;
			$_SESSION['logged_in_user'] = $lRecord->username;
			$_SESSION['logged_in_usersignature'] = $lRecord->mysignature;
			$_SESSION['is_admin'] = $lRecord->is_admin;

   				/*
   				 /* Set client-side auth token. if we are in insecure mode, we will
   				* pay attention to client-side authorization tokens. If we are secure,
   				* we dont use client-side authortization tokens and we ignore any
   				* attempts to use them.
   				*
   				* If in secure mode, we want the cookie to be protected
   				* with HTTPOnly flag. There is some irony here. In secure code,
   				* we are to ignore authorization cookies, so we are protecting
   				* a cookie we know we are going to ignore. But the point is to
   				* provide an example to developers of proper coding techniques.
   				*
   				* Note: Ideally this cookie must be protected with SSL also but
   				* again this is just a demo. Once your in SSL mode, maintain SSL
   				* and escalate any requests for HTTP to HTTPS.
   				*/
			if ($lProtectCookies){
				$lUsernameCookie = $Encoder->encodeForURL($lRecord->username);
				$l_cookie_options = array (
				    'expires' => 0,              // 0 means session cookie
				    'path' => '/',               // '/' means entire domain
				    //'domain' => '.example.com', // default is current domain
				    'secure' => FALSE,           // true or false
				    'httponly' => TRUE,         // true or false
				    'samesite' => 'Strict'          // None || Lax  || Strict
				);
				setcookie("username", $lUsernameCookie, $l_cookie_options);
				setcookie("uid", $lRecord->cid, $l_cookie_options);
			}else {
				//setrawcookie() allows for response splitting
				$lUsernameCookie = $lRecord->username;
				$l_cookie_options = array (
				    'expires' => 0,              // 0 means session cookie
				    'path' => '/',               // '/' means entire domain
				    //'domain' => '.example.com', // default is current domain
				    'secure' => FALSE,           // true or false
				    'httponly' => FALSE,         // true or false
				    'samesite' => 'Lax'          // None || Lax  || Strict
				);
				setrawcookie("username", $lUsernameCookie, $l_cookie_options);
				setrawcookie("uid", $lRecord->cid, $l_cookie_options);
			}// end if $lProtectCookies

			logLoginAttempt("Login Succeeded: Logged in user: {$lRecord->username} ({$lRecord->cid})");

			$lAuthenticationAttemptResult = $cAUTHENTICATION_SUCCESSFUL;

			/* Redirect back to the home page and exit to stop adding to HTTP response*/
			header('Location: index.php?popUpNotificationCode=AU1', true, 302);
			exit(0);

		}// end if $lAuthenticationAttemptResultFound

   	} catch (Exception $e) {
		echo $CustomErrorHandler->FormatError($e, "Error querying user account");
		$lAuthenticationAttemptResult = $cAUTHENTICATION_EXCEPTION_OCCURED;
	}// end try;

?>
