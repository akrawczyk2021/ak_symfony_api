<?php

declare(strict_types=1);

namespace App\Request;

class ShowCard
{
    public function __construct(private string $name, private string $description, private int $attack, private int $defense, private int $hp)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAttack(): int
    {
        return $this->attack;
    }
    
    public function getDefense(): int
    {
        return $this->defense;
    }

    public function getHp(): int
    {
        return $this->hp;
    }
}
