<?php

declare (strict_types=1);

namespace App\Response;

use PhpParser\Node\Name;

class UserResponse{

    private $name;
    private $email;
    private $password;

    public function __construct(string $name, string $email,string $password)
    {
        $this->name=$name;
        $this->email=$email;
        $this->password=$password;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }
    
    public function getDtoAsArray()
    {
        return ['name'=>$this->name,'mail'=>$this->email];
    }

    public function __toString()
    {
        return $this->name." ".$this->email;
    }

}