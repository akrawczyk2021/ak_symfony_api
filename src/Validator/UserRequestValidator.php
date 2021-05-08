<?php

namespace App\Validator;

use App\Response\UserResponse;
use Codeception\Util\HttpCode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Response\UserResponseNoPassword;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRequestValidator{

    public function decodeContent(Request $request){
        if($this->isValid($request)){
            $datarequest=json_decode($request->getContent(),true);
            return 2;
            //return new UserResponseNoPassword($datarequest['name'],$datarequest['email']);
        }else{
            return null;
        }
    }

    public function isValid(Request $request): bool{
        
        if($request->getContentType()=='json'){
            if ($this->validateJsonParams(json_decode($request->getContent(),true))){
                return true;
            }else{
                //throw $this->createNotFoundException("Wrong data format");    
                return false;
            }
        }else{
            //throw $this->createNotFoundException("Wrong data format");
            return false;
        }
    }

    private function validateJsonParams(array $params): bool{
        if(empty($params['name'])){
            throw new HttpException(404,"Name cannot be empty");
            return false;
        }
        if(empty($params['mail'])){
        throw new HttpException(404,"Email cannot be empty");
            return false;
        }
        if(empty($params['password'])){
            throw new HttpException(404,"Password cannot be empty");
            return false;
        }
        
        return true;
    }

    
}

?>