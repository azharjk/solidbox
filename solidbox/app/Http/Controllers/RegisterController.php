<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Models\User;
use App\Http\Resources\TokenResource;
use App\Constants\TokenConstant;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users|min:8',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->errors());
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = $user->createToken(TokenConstant::TOKEN_NAME);

        return new TokenResource($token);
    }
}
