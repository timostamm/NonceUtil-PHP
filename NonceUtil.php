<?php 


/**
 *
 * A tiny Nonce generator with variable time-outs.
 * 
 * No database required.
 * Each Nonce has its own Salt.
 * 
 */
class NonceUtil {
	
	
	/**
	 * Generate a Nonce. 
	 * 
	 * The generated string contains three parts, seperated by a comma.
	 * The first part is the individual salt. The seconds part is the 
	 * time until the nonce is valid. The third part is a hash of the 
	 * salt, the time, and a secret value.
	 * 
	 * @param $secret required String with at least 10 characters. The 
	 * same value must be passed to check(). 
	 * 
	 * @param $timeoutSeconds the time in seconds until the nonce 
	 * becomes invalid. 
	 *
	 * @return string the generated Nonce.
	 *
	 */
	public static function generate($secret, $timeoutSeconds=180) {
		if (is_string($secret) == false || strlen($secret) < 10) {
			throw new InvalidArgumentException("missing valid secret");
		}
		$salt = self::generateSalt();
		$time = time();
		$maxTime = $time + $timeoutSeconds;
		$nonce = $salt . "," . $maxTime . "," . sha1( $salt . $secret . $maxTime );
		return $nonce;
	}
	
	
	/**
	 * Check a previously generated Nonce.
	 *
	 * @param $secret the secret string passed to generate().
	 * 
	 * @returns bool whether the Nonce is valid.
	 */
	public static function check($secret, $nonce) {
		if (is_string($nonce) == false) {
			return false;
		}
		$a = explode(',', $nonce);
		if (count($a) != 3) {
			return false;
		}
		$salt = $a[0];
		$maxTime = intval($a[1]);
		$hash = $a[2];
		$back = sha1( $salt . $secret . $maxTime );
		if ($back != $hash) {
			return false;
		}
		if (time() > $maxTime) {
			return false;
		}
		return true;
	}
	
	
	private static function generateSalt() {
		$length = 10;
		$chars='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		$ll = strlen($chars)-1;
		$o = '';
		while (strlen($o) < $length) {
			$o .= $chars[ rand(0, $ll) ];
		}
		return $o;
	}
	
	
}


?>