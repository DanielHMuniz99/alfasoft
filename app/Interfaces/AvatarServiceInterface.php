<?php

namespace App\Interfaces;

interface AvatarServiceInterface
{
    public function generateUrl(string $name): string;
}
