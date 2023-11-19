<?php

namespace Intervention\Image\Drivers\Imagick\Modifiers;

use Intervention\Image\Drivers\DriverModifier;
use Intervention\Image\Exceptions\ColorException;
use Intervention\Image\Interfaces\ImageInterface;

class ProfileModifier extends DriverModifier
{
    public function apply(ImageInterface $image): ImageInterface
    {
        $imagick = $image->core()->native();
        $result = $imagick->profileImage('icc', (string) $this->profile);

        if ($result === false) {
            throw new ColorException('ICC color profile could not be set.');
        }

        return $image;
    }
}
