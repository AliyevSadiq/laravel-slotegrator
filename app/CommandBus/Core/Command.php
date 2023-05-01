<?php

namespace App\CommandBus\Core;

use ReflectionClass;

abstract class Command
{
    public function handlePayload(array $payload): self
    {
        if (empty($payload)) {
            return $this;
        }

        $reflection = new ReflectionClass($this);
        foreach ($payload as $field => $value) {
            if (!$reflection->hasProperty($field)) {
                continue;
            }

            $property = $reflection->getProperty($field);
            $property->setValue($this, $value ?? null);
        }

        return $this;
    }
}
