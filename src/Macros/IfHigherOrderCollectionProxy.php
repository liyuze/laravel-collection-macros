<?php

namespace Liyuze\CollectionMacros\Macros;

use Illuminate\Support\Enumerable;

/**
 * @mixin Enumerable
 */
class IfHigherOrderCollectionProxy
{
    protected Enumerable $collection;

    protected mixed $when;

    /**
     * @var Enumerable|mixed
     */
    protected $value;

    /**
     * Create a new proxy instance.
     *
     * @param  \Illuminate\Support\Enumerable  $collection
     * @return void
     */
    public function __construct(Enumerable $collection, $when)
    {
        $this->collection = $collection;
        $this->value = clone $collection;
        $this->when = $when;
    }

    public function getCollection(): Enumerable
    {
        return $this->collection;
    }

    public function ifThen(mixed $value): static
    {
        $this->when = boolval(value($value));
        return $this;
    }

    public function unlessThen(mixed $value): static
    {
        $this->when = !boolval(value($value));
        return $this;
    }

    public function else(): static
    {
        $this->when = !$this->when;
        return $this;
    }

    public function after(callable $callback): static
    {
        $this->value = $callback($this->value, $this->collection);
        return $this;
    }

    /**
     * @param  mixed|null  $default
     * @return mixed|Enumerable
     */
    public function value(mixed $default = null)
    {
        return $this->value ?? value($default);
    }

    /**
     * @param  string  $key
     * @return mixed|static
     */
    public function __get(string $key)
    {
        if ($this->when) {
            $this->value = is_array($this->value) ? $this->value[$key] : $this->value->{$key};
        }
        return $this;
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return \Illuminate\Support\Enumerable|static
     */
    public function __call(string $method, array $parameters)
    {
        if ($this->when) {
            $this->value = $this->value->{$method}(...$parameters);
        }
        return $this;
    }
}
