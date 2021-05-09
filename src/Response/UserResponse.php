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
        return $this->getName();
    }

    public function getEmail(): string{
        return $this->getEmail();
    }

    public function getPassword(): string{
        return $this->getPassword();
    }
    
    public function __toString()
    {
        return json_encode(['name'=>$this->name,'mail'=>$this->email]);
    }

}