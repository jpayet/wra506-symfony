<?php

namespace App\Services;

use Symfony\Component\String\Slugger\AsciiSlugger;

class Slugify
{
    public function generateSlug(string $text): string
    {
        $slugger = new AsciiSlugger();
        return $slugger->slug($text);
    }
}
