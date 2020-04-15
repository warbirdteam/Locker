<?php

class API_Crypt {

    private $cipher;
    private $key;
    public $iv;
    public $tag;

    public function __construct() {
        $config = json_decode(file_get_contents(__DIR__ . '/../config/key.json'), true);
        $this->key = $config['key']['key'];
        $this->cipher = $config['key']['cipher'];
    }

    private function pkcs7_unpad($data)
    {
        return substr($data, 0, -ord($data[strlen($data) - 1]));
    }

    private function pkcs7_pad($data, $size)
    {
        $length = $size - strlen($data) % $size;
        return $data . str_repeat(chr($length), $length);
    }

    public function unpad($enc_api, $iv, $tag) {
      $api = $this->pkcs7_unpad(openssl_decrypt(
          $enc_api,
          $this->cipher,
          $this->key,
          0,
          $iv,
          $tag
      ));

      return $api;
    }

    public function pad($api)
    {

        $iv_size = openssl_cipher_iv_length($this->cipher);
        $this->iv = random_bytes($iv_size);

        $enc_api = openssl_encrypt(
          $this->pkcs7_pad($api, 16),  // padded data
          $this->cipher,        // cipher and mode
          $this->key,      		  // secret key
          0,                    // options (not used)
          $this->iv,            // initialisation vector
          $this->tag
        );


        return $enc_api;

    }

}

?>
