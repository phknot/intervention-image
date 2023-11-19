<?php

namespace Intervention\Image\Drivers;

use Intervention\Image\Interfaces\DriverInterface;
use ReflectionClass;

abstract class AbstractDriver implements DriverInterface
{
    public function resolve(object $input): object
    {
        $ns = (new ReflectionClass($this))->getNamespaceName();
        $classname = (new ReflectionClass($input))->getShortName();

        preg_match("/(?P<dept>[A-Z][a-z]+)$/", $classname, $matches);
        $department = array_key_exists('dept', $matches) ? $matches['dept'] : null;
        $department = match ($department) {
            'Modifier', 'Writer' => 'Modifiers',
            'Encoder' => 'Encoders',
            default => null,
        };

        $specialized = implode("\\", array_filter([
            $ns,
            $department,
            $classname
        ], function ($dept) {
            return !empty($dept);
        }));

        return new $specialized($input, $this);
    }
}
