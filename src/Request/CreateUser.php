<?php

declare(strict_types=1);

namespace App\Request;

class CreateUser
{
    private string $name = "";
    private string $email = "";
    private string $password = "";

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}
