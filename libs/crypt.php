<?php 

class Crypto
{
    public $cipher = "AES-128-CTR";
    public $key = "Reconnect";
    public $iv = '1234567891011121';
    function Encrypt($word)
    {
        $iv_length = openssl_cipher_iv_length($this->cipher);
        $options = 0;
        return openssl_encrypt($word, $this->cipher, $this->key, $options, $this->iv);
    }
    function Decrypt($word)
    {
        $iv_length = openssl_cipher_iv_length($this->cipher);
        $options = 0;
        return openssl_decrypt ($word, $this->cipher,  $this->key, $options, $this->iv);
    }
    function WordToHash($word)
    {
        return hash('md5', $word);
    }
}

?>