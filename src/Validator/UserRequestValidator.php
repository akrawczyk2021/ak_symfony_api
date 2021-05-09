<?php

namespace App\Validator;

use Codeception\Util\HttpCode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repository\UsersRepository;

class UserRequestValidator
{

    private $usersrepository;
    public function __construct(UsersRepository $usersrepository)
    {
        $this->usersrepository = $usersrepository;
    }

    public function isJsonRequestTypeValid(Request $request): bool
    {

        if ($request->getContentType() == 'json') {
            return true;
        } else {
            throw new HttpException(HttpCode::BAD_REQUEST, "Wrog data format");
        }
    }

    public function isJsonParamsValid(array $params): bool
    {
        if (empty($params['name'])) {
            throw new HttpException(HttpCode::BAD_REQUEST, "Name cannot be empty");
        }
        if (empty($params['email'])) {
            throw new HttpException(HttpCode::BAD_REQUEST, "Email cannot be empty");
        }
        if (empty($params['password'])) {
            throw new HttpException(HttpCode::BAD_REQUEST, "Password cannot be empty");
        }

        return true;
    }

    public function isPasswordValid(string $password): bool
    {
        $pattern = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])/';
        if (preg_match($pattern, $password) == 1) {
            return true;
        } else {
            throw new HttpException(HttpCode::BAD_REQUEST, "Password must contain at least 1 small letter, 1 big, 1 number");
            return false;
        }
    }

    public function isEmailUnique(String $email): bool
    {
        $useremail = $this->usersrepository->findBy(['email' => $email]);
        if ($useremail == null) {
            return true;
        } else {
            throw new HttpException(HttpCode::BAD_REQUEST, "Email already exists");
        }
    }
}
