<?php

namespace App\GraphQL\Mutations;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

final class Login
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $user=User::where('email',$args['email'])->first();

        if(! $user || ! Hash::check($args['password'], $user->password)){
            throw ValidationException::withMessages([
                'email'=>['the provided credinatls not correct'],
            ]);
        }
        return $user->createToken($args['device'])->plainTextToken;
    }
}
