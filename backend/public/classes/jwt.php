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

    public function createJWT($payload = 0)
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

    
}
