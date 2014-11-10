<?php

define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

function create_hash($password)
{
	$salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
	return PBKDF2_HASH_ALGORITHM . 
		":" . PBKDF2_ITERATIONS . 
		":" .  
		$salt . 
		":" . 
		base64_encode(
			hash_pbkdf2(
				PBKDF2_HASH_ALGORITHM,
				$password,
				$salt,
				PBKDF2_ITERATIONS,
				PBKDF2_HASH_BYTE_SIZE,
				true
			)
		);
}

function validate_password($password, $correct_hash)
{
	$params = explode(":", $correct_hash);
	if(count($params) < HASH_SECTIONS) {
		return false; 
	}
	$pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
	return slow_equals(
		$pbkdf2, 
		hash_pbkdf2(
			$params[HASH_ALGORITHM_INDEX],
			$password,$params[HASH_SALT_INDEX],
			(int)$params[HASH_ITERATION_INDEX],
			strlen($pbkdf2),
			true
		)
	);
}

function slow_equals($a, $b)
{
	$diff = strlen($a) ^ strlen($b);
	for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
	{
		$diff |= ord($a[$i]) ^ ord($b[$i]);
	}
	return $diff === 0; 
}

?>

