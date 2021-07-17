<?php

declare(strict_types=1);

namespace App\Handler;

use App\Request\EditCard;

class Handler
{
    public function __construct(private EditCard $editCard)
    {
    }

    public function handle(): void
    {
        //update class
        1 == 1;
    }
}
