<?php

namespace Fleche;

class Route
{
    public array $middlewares = [];

    public function __construct(
        public string $methode,
        public string $uri,
        public mixed $action
    ) {}

    public function middleware(string ...$middlewares): self
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
        return $this;
    }
}
