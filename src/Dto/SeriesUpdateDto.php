<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\InputBag;

class SeriesUpdateDto
{
    public readonly string $name;
    public function __construct(InputBag $form)
    {
        $this->name = strtolower($form->get('name'));
    }
}