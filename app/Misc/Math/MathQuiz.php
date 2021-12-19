<?php

namespace App\Misc\Math;

use Illuminate\Http\Exceptions\HttpResponseException;

abstract class MathQuiz
{
    protected array $data   = [];
    protected array $result = [];

    protected MathQuizLogger $logger;

    /**
     * MathQuiz constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;

        $this->logger = new MathQuizLogger(static::name(), $data);

        $this->validate();
        $this->solve();

        $this->logger->write();
    }

    /**
     * Unique quiz name
     *
     * @return string
     */
    public static function name()
    {
        return __CLASS__;
    }

    /**
     * @return int
     */
    public function hits(): int
    {
        return $this->logger->hits();
    }

    abstract function validate(): void;

    abstract function solve(): void;

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array $result
     */
    protected function setResult(array $result)
    {
        $this->result = $result;
    }

    /**
     * @param int|string $property
     * @param mixed      $default
     *
     * @return mixed
     */
    protected function get(int|string $property, $default = null): mixed
    {
        return data_get($this->data, $property, $default);
    }

    /**
     * @param array $properties
     * @param mixed $default
     *
     * @return array
     */
    protected function getBulk(array $properties, $default = null): array
    {
        $result = [];

        foreach ($properties as $property)
        {
            $result[] = $this->get($property, $default);
        }

        return $result;
    }

    /**
     * @param int|string $property
     *
     * @return bool
     */
    protected function exists(int|string $property): bool
    {
        return array_key_exists($property, $this->data);
    }

    /**
     * @param array $properties
     *
     * @return bool
     */
    protected function existsBulk(array $properties): bool
    {
        foreach ($properties as $property)
        {
            if (!$this->exists($property))
            {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string|int|null $param
     * @param                 $message
     *
     * @return HttpResponseException
     */
    protected function error(string|int|null $param, $message): HttpResponseException
    {
        throw new HttpResponseException(response()->json(['errors' => [$param => $message]], 422));
    }
}
