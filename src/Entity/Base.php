<?php

namespace App\Entity;

use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

abstract class Base
{
    use TimestampableEntity;
    use BlameableEntity;
}