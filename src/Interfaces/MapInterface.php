<?php

namespace Maps\Interfaces;

interface MapInterface
{
    public function render(): string;

    public function setCustomView(string $viewPath): void;
}