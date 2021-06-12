<?php

declare(strict_types=1);

namespace App\Request;

class CreateCard
{
    private string $name;
    private string $description;
    private int $hp;
    private int $attack;
    private int $defense;

    public function __construct(string $name, string $description, int $attack, int $defense, int $hp)
    {
        $this->name = $name;
        $this->description = $description;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->hp = $hp;
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
