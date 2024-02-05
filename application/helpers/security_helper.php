<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
function encrypt_url($string) {
    $output = false;
    /*
    * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
    */        
    $security       = parse_ini_file("security.ini");
    $secret_key     = $security["encryption_key"];
    $secret_iv      = $security["iv"];
    $encrypt_method = $security["encryption_mechanism"];
    // hash
    $key    = hash("sha256", $secret_key);
    // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
    $iv     = substr(hash("sha256", $secret_iv), 0, 16);
    //do the encryption given text/string/number
    $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($result);
    return $output;
}
function decrypt_url($string) {
    $output = false;
    /*
    * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
    */
    $security       = parse_ini_file("security.ini");
    $secret_key     = $security["encryption_key"];
    $secret_iv      = $security["iv"];
    $encrypt_method = $security["encryption_mechanism"];
    // hash
    $key    = hash("sha256", $secret_key);
    // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
    $iv = substr(hash("sha256", $secret_iv), 0, 16);
    //do the decryption given text/string/number
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}

function key_id() {
    $output = 'APwXEdcUOPFAbnbwlAshSi737fSSLffOTA3A1685195556975sourcehpeiJAtyZPCeOdfg4EPpua8sA4iflsigAOEireoAAAAAZHIZNDcg9CRmJKnYMvKlPLv5ZdTMcrNGved0ahUKEwjwwLHU0pXAhVX8DgGHSYzDYQ4dUDCAkuact5oqsupardiwajabaegslcpCgdnd3Mtd2l6EAM6BAgjECc6CAgAEIoFEJECOgcIABCKBRBDOgsIABCABBCxAxCDAToICAAQgAQQsQM6BwgjEOoCECc6BwgjEIoFECc6DQgAEIoFELEDEIMBEEM6EQguEIAEELEDEIMBEMcBENEDOgsIABCKBRCxAxCDAToFCC4QgAQ6DgguEIMBENQCELEDEIAEOgUIABCABDoOCC4QgAQQsQMQxwEQ0QM6CwguENQCELEDEIAEOgsILhCABBCxAxDUAjoKCAAQigUQsQMQQzoHCC4QigUQQzoLCC4QgAQQxwEQ0QM6CwguEIAEEMcBEK8BOg4ILhCABBCxAxCDARDUAjoLCC4QxwEQ0QMQywE6BQguEMsBOggILhDUAhDLAToFCAAQywE6CwguEMcBEK8BEMsBOgcILhAKEMsBOgcILhANEIAEOgcIABANEIAEOgkILhANEIAEEAo6CQgAEA0QgAQQCjoFCAAQogQ6BggAEBYQHjoICAAQigUQhgM6BQghEKABOgcIIRCgARAKUABY7yVg3idoBHAAeACAAeIBiAHFFZIBBjMuMTQuMpgBAKABAbABCg';
    return $output;
}

function paket() {
    $output = 'com.tripointeknologi.kudmandarberkahmandiri';
    return $output;
}


function hapus($str){
	return str_replace(' ', '',$str);
}