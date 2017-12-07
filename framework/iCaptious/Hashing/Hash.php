<?php
namespace iCaptious\Hashing;

 
class Hash
{

	// Hashing Algorithm
	const SHA1   = "sha1";
	const SHA256 = "sha256";
	const SHA384 = "sha384";
	const SHA512 = "sha512";
	const MD2    = "md2";
	const MD4 	 = "md4";
	const MD5    = "md5";

	
	const DEFAULT_CRYPT = PASSWORD_BCRYPT;

    /**
     * Generate the Hash of a string
     * 
     * @param  string $pass     string/password to be hashed
     * @param  mixed  $HashType the type of hash used to hash the password
     * @return mixed
     */
    public static function Hash($pass, $HashType = self::DEFAULT_CRYPT){
        return password_hash($pass, $HashType);
    }

    /**
     * Verify if the password is equals to the Hash from DB
     * 
     * @param  string $pass the string/password given to be checked if the are equaly
     * @param  mixed  $hash the hash from the database
     * @return bool
     */
    public static function VerifyHash($pass, $hash){
        $filteredHash = end(explode("||", $hash)); // Filter the hash from database and give the real hash
        return password_verify($pass, $filteredHash); 
    }

    /**
     * Encrypt and decrypt
     *
     * @param  string $string string to be encrypted/decrypted
     * @param  string $action what to do with this? e for encrypt, d for decrypt
     * @return mixed
     */
    public static function CCrypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'ooisihdodiiugdadzgfwefufaifzufwazgfaavvvcyvgcazvvfassahgvaksggvf';
        $secret_iv = 'lgaigfzgakzegfgazwfefif612368tewf766rtfaewfkhsdofuwjhnxcmbbcmnbcy';
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
    }

	/**
	 * Generate a Key using different types of algorithms
	 * 
	 * @param  string $append
	 * @param  string $algo   Type of algorithms
	 * @return mixed
	 */
	public static function Keygen($append = "", $algo = "sha256"){
		$bytes = openssl_random_pseudo_bytes(32);
		$random_hash = base64_encode($bytes);
		$random_hash .= $append.$random_hash;
		$Hash = hash($algo, $random_hash);
		return $Hash;
	}
}