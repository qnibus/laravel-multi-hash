<?php

namespace Qnibus\LaravelJasyptHash\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\AbstractHasher;

/**
 * Jasypt Digester
 * Jasypt to PHP converted
 *
 * @see Jasypt (Java simplified encryption) <http://www.jasypt.org/>
 */
class JasyptHasher extends AbstractHasher implements HasherContract
{
    /**
     * @var mixed|string algorithm name
     */
    protected $algoName = 'sha256';

    /**
     * @var bool|mixed algorithm for validation (don't modify for currently not worked)
     */
    protected $verifyAlgorithm = false;

    /**
     * @var int iteration (cost)
     */
    protected $iteration = 1000;

    public function __construct(array $options = [])
    {
        $this->algoName = $options['algoName'];
        $this->verifyAlgorithm = $options['verify'] ?? $this->verifyAlgorithm;
        $this->iteration = $options['iteration'] ?? $this->iteration;
    }

    /**
     * @inheritDoc
     */
    public function make($value, array $salt = [])
    {
        $salt = blank($salt) ? $this->generateSalt() : $salt;

        if (is_array($value)) {
            $value = array_merge($salt, $value);
            for ($i = 1; $i <= $this->iteration; $i++) {
                $value = hash($this->algoName, $this->getString($value), true);
                $value = $this->getBytes($value);
            }
            $value = array_merge($salt, $value);

            return base64_encode($this->getString($value));
        } else if (is_string($value)) {
            $bytes = $this->getBytes(normalizer_normalize(utf8_encode($value)));

            return $this->make($bytes, $salt);
        }
    }

    /**
     * @inheritDoc
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] !== 'sha256') {
            throw new RuntimeException('This password does not use the ' . $this->algoName . ' algorithm.');
        }

        return $hashedValue == self::make($value, array_slice(
            $this->getBytes(base64_decode($hashedValue)),
            0,
            16
        ));
    }

    /**
     * Generate salt
     *
     * @return array 16bytes salt
     */
    private function generateSalt()
    {
        $salt = bin2hex(openssl_random_pseudo_bytes(8)); // 16bytes

        return $this->getBytes(utf8_encode($salt));
    }

    /**
     * String to bytes array
     *
     * @param string $string raw data
     * @return array
     */
    private function getBytes($string)
    {
        return array_map(
            'decbin',
            array_slice(
                unpack("C*", "\0" . $string),
                1
            )
        );
    }

    /**
     * Bytes array to string
     *
     * @param array $bytes
     * @return mixed
     */
    private function getString($bytes)
    {
        $bytes = array_map('bindec', $bytes);
        $string = call_user_func_array("pack", array_merge(["C*"], $bytes));

        return $string;
    }
}
