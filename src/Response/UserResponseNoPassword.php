<?php

declare(strict_types=1);

namespace App\Response;

class UserResponseNoPassword{

    private $ErrorMessage;

    public function __construct(private string $name, private string $email,private string $password)
    {
        
    }

    public function getName(): string{
        return $this->getName();
    }

    public function getEmail(): string{
        return $this->getEmail();
    }

    public function getPassword(): string{
        return $this-getPassword();
    }

    public function getErrorMessage(): string{
        return $this->getErrorMessage();
    }

    public function setErrorMessage(string $message){
        $this->ErrorMessage=$message;
    }
    
    public function __toString()
    {
        return json_encode(['name'=>$this->name,'mail'=>$this->email]);
    }
}