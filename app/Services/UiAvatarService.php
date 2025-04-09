<?php

namespace App\Services;

use App\Interfaces\AvatarServiceInterface;

class UiAvatarService implements AvatarServiceInterface
{
    public function generateUrl(string $name): string
    {
        $encodedName = urlencode($name);
        return "https://ui-avatars.com/api/?background=random&name={$encodedName}";
    }
}
