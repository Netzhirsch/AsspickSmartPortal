<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

class EntityGroupType extends AbstractType
{
    public function getParent(): string
    {
        return EntityType::class;
    }
}
