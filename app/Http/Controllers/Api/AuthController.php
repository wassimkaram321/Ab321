<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\OTP;
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
        $request->merge(['password'=>Hash::make($request->password)]);
        return User::updateOrCreate(['phone' => $request->phone], $request->all());
    }
    public function userProfile(LoginRequest $request)
    {
        $data = Auth::user();
        return $this->success($data,'success');
    }
    public function generateOTP(LoginRequest $request)
    {
        $code = rand(111111, 999999);
        $otp = OTP::updateOrCreate(
           ["phone" => $request->phone],
           ["code" => $code]
        );
        $data = ['phone'=>$otp->phone,'code'=>$otp->code];
        return $this->success($data,'success');
    }
    public function verifyOTP(LoginRequest $request)
    {
        $otp = OTP::wherecode($request->code)->get()->first();
        if($otp->code == $request->code){
            return $this->success([],'success');
        }
        else{
            return $this->error_message('Wrong Code');
        }
            
    }
    public function resetPassword(LoginRequest $request)
    {
        $otp = OTP::wherecode($request->code)->get()->first();
        if($otp->code == $request->code){
            $user = User::find($otp->phone)->update([
                'password' => $request->password,
            ]);
            return $this->success([],'success');
        }
        else{
            return $this->error_message('Wrong Code');
        }
            
    }
}
