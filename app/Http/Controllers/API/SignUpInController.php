<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class SignUpInController extends BaseController
{
    //
    public function login(Request $request)
    {

    	$validator =Validator::make($request->all(),[

    		'email'=>'required|string|email|max:255',
    		'password'=>'required'

    		]);

    	if ($validator->fails()) 
        {
               return $this->sendError($validator->errors());
    	}

    	$credentials= $request->only('email','password');
    	try 
    	{
    		if (! $token =JWTAuth::attempt($credentials)) {
    			
                 return $this->sendError('invalid username or password');
    		}

    	}catch(JWTException $e)
    	{	
            return $this->sendError('could not create token',500);
    	}

        return $this->sendResponse(compact('token'), 'login is successfuly');

    }


    public function register(Request $request)
        {

            $validator =Validator::make($request->all(),[

                'firstName'=>'required',
                'lastName'=>'required',
                'email'=>'required|string|email|max:255|unique:users',
                'mobile'=>'required',
                'password'=>'required',
                ]);

            if ($validator->fails()) {
                # code...
               return $this->sendError($validator->errors());
            }

            $user=User::create([

                'firstName'=>$request->get('firstName'),
                'lastName'=>$request->get('lastName'),
                'email'=>$request->get('email'),
                'mobile'=>$request->get('mobile'),
                'password'=>bcrypt($request->get('password')),

                ]);
            //$user=User::first();
           // $token = JWTAuth::fromUser($user);
           // return $this->sendResponse(compact('token'), 'SignUp is successfuly');
             return $this->sendResponse($user->toArray(), 'SignUp is successfuly');

        }

}
