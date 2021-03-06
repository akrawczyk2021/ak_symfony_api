<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Card")
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="integer")
     */
    private int $attack;

    /**
     * @ORM\Column(type="integer")
     */
    private int $hp;

    /**
     * @ORM\Column(type="integer")
     */
    private int $defense;

    public function __construct(string $name, int $hp, int $attack, int $defense)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->description = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }
}
