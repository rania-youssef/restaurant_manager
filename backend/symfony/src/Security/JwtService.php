<?php
namespace App\Security;

class JwtService
{
    public function __construct(
        private string $secret,
        private int $ttl
    ) {}

    public function generate(array $payload): string
    {
        $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload['exp'] = time() + $this->ttl;
        $payloadEncoded = base64_encode(json_encode($payload));

        $signature = base64_encode(
            hash_hmac('sha256', "$header.$payloadEncoded", $this->secret, true)
        );

        return "$header.$payloadEncoded.$signature";
    }

    public function validate(string $token): ?array
    {
        [$header, $payload, $signature] = explode('.', $token);

        $expected = base64_encode(
            hash_hmac('sha256', "$header.$payload", $this->secret, true)
        );

        if (!hash_equals($expected, $signature)) return null;

        $data = json_decode(base64_decode($payload), true);

        return ($data['exp'] >= time()) ? $data : null;
    }
}
