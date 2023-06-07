<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\AuthControllerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    //
    use ResponseTrait;
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->orWhere('phone',$request->phone)->first();
        $hash = Hash::check($request->password, $user->password);
        $data = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email];
        if ($hash == 0) {
            return $this->error_message('wrong password');
        } elseif (!$data) {
            return $this->error_message('not found');
        } else {
            $token = $user->createToken(time())->plainTextToken;
            $arr = ['token' => $token, 'role_id' => $user->role_id];
            $data_with_token = array_merge($data, $arr);
            return $this->success($data_with_token,'success');
        }
    }
    public function logout(Request $request)
    {

        $user = User::find(Auth::id());
        if (!empty($user)) {
            $request->user()->currentAccessToken()->delete();
        }
        else{
           $this->error_message('User Not Found');
        }
        return $this->success([],'success');
    }
    public function register(LoginRequest $request)
    {
        return User::create($request->all());
    }
}
