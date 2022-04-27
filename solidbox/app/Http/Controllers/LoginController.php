<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Models\User;
use App\Constants\TokenConstant;
use App\Http\Resources\TokenResource;

class LoginController extends Controller
{
    public function isValidCredential($validated) {
        $user = User::where('username', $validated['username'])->first();

        if (! $user) {
            return null;
        }

        if (Hash::check($validated['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException($validator->errors());
        }

        $validated = $validator->validated();

        $user = $this->isValidCredential($validated);

        if (! $user) {
            return response()->json([
                'message' => 'Incorrect credential'
            ]);
        }

        $token = $user->createToken(TokenConstant::TOKEN_NAME);

        return new TokenResource($token);
    }
}
