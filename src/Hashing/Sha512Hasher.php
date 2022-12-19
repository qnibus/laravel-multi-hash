<?php

namespace Qnibus\LaravelJasyptHash\Hashing;

use App\Library\Hashing\RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

/**
 *
 */
class Sha512Hasher implements HasherContract
{
    /**
     * @var bool|mixed
     */
    protected $verifyAlgorithm = false;

    /**
     * @var mixed|string
     */
    protected $algoName = 'sha512';

    /**
     * @var string|mixed
     */
    protected string $key = '';

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->algoName = $options['algoName'];
        $this->verifyAlgorithm = $options['verify'] ?? $this->verifyAlgorithm;
        $this->key = $options['key'] ?? $this->key;
    }

    /**
     * @inheritDoc
     */
    public function info($hashedValue): array
    {
        return [
            'algo' => null,
            'algoName' => $this->algoName,
            'options' => []
        ];
    }

    /**
     * @inheritDoc
     */
    public function make($value, array $options = []): string
    {
        $this->key = $options['key'] ?? $this->key;

        if (isset($this->key)) {
            $hash = hash_hmac($this->algoName, $value, $this->key, true);
        } else {
            $hash = hash($this->algoName, $value, true);
        }

        return base64_encode($hash);
    }

    /**
     * @inheritDoc
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        if ($this->verifyAlgorithm && $this->info($hashedValue)['algoName'] !== 'sha512') {
            throw new RuntimeException('This password does not use the ' . $this->algoName . ' algorithm.');
        }

        return self::make($value, $options) === $hashedValue;
    }

    /**
     * @inheritDoc
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return false;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = (string) $key;

        return $this;
    }
}
