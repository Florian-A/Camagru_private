<?php
class JWT
{
    private $crossImport = 0;

    public function __construct($crossImport = 0)
    {
        $this->crossImport = $crossImport;
    }

    private function base64UrlEncode($data)
    {
        return strtr(base64_encode($data), '+/=', '-_,');
    }

    private function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_,', '+/='));
    }

    public function create($payload = 0)
    {
        if ($this->crossImport === 0) {
            return 0;
        }
        // Creating a token header in the form of a JSON string.
        $header = json_encode(
            [
                "typ" => "JWT",
                "alg" => "HS256"
            ]
        );

        // Signature creation
        $signature = $this->generateJWTSignature($this->base64UrlEncode($header), $this->base64UrlEncode($payload));

        // JWT token creation
        $jwt = $this->base64UrlEncode($header) . "." . $this->base64UrlEncode($payload) . "." . $this->base64UrlEncode($signature);

        return $jwt;
    }

    public function generateJWTSignature($header, $payload)
    {
        // Signature creation
        $signature = hash_hmac('sha256', $header . "." . $payload, getenv('JWT_SECRET'), true);

        return $signature;
    }

    private function verify($token = null) {

        // If the token is null or doesn't have 3 parts, return 0
        if ($token === null || count(explode(".", $token)) !== 3) {
            return false;
        }

        // Split the token into its three parts 
        [$header, $payload, $signature] = array_map([$this, 'base64UrlDecode'], explode(".", $token));

        $payloadObj = json_decode($payload);

        $recalcSignature = $this->generateJWTSignature($this->base64UrlEncode($header), $this->base64UrlEncode($payload));
        $tokenExpTime = filter_var($payloadObj->exp, FILTER_SANITIZE_NUMBER_INT);

        // If the new signature matches the original signature and the token hasn't expired, return 1
        return ($recalcSignature == $signature && $tokenExpTime >= time()) ? true : false;
    }

    public function getUserId($token = null) {

        if ($this->verify($token) === false) {
            return 0;
        }

        [$dummy, $payload, $dummy] = array_map([$this, 'base64UrlDecode'], explode(".", $token));

        $payloadObj = json_decode($payload);
        if (isset($payloadObj)) {
            return $payloadObj->userId;
        } else {
            return 0;
        }
    }
    
    
    
}
