<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordRequest;
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
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        $hash = Hash::check($request->password, $user->password);
        $data = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email,'phone'=>$user->phone];
        if ($hash == 0) {
            return $this->error_message('wrong password');
        } elseif (!$data) {
            return $this->error_message('not found');
        } else {
            $token = $user->createToken(time())->plainTextToken;
            $arr = ['token' => $token, 'role_id' => $user->role_id];
            $data_with_token = array_merge($data, $arr);
            return $this->success($data_with_token, 'success');
        }
    }
    public function logout(Request $request)
    {

        $user = User::find(Auth::id());

        if (!empty($user)) {
            $request->user()->currentAccessToken()->delete();
            $user->update([
                'device_token'=>null
            ]);
        } else {
            $this->error_message('User Not Found');
        }

        return $this->success([], 'success');
    }
    public function register(LoginRequest $request)
    {


        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::updateOrCreate(['phone' => $request->phone], $request->all());
        if ($request->has('avatar')) {
            $user->update([
                'avatar' => FileHelper::addFile($request->file('avatar'), 'images/users'),
            ]);
        }
        return $this->success($user, 'success');
    }
    public function userProfile(LoginRequest $request)
    {
        $data = User::where('id', Auth::id())->first();
        $data->unseen_notification_count = $data->notifications()->where('seen', 0)->orderBy('created_at', 'desc')->count();
        return $this->success($data, 'success');
    }
    public function generateOTP(LoginRequest $request)
    {
        $code = rand(111111, 999999);
        $otp = OTP::updateOrCreate(
            ["phone" => $request->phone],
            ["code" => $code]
        );
        $data = ['phone' => $otp->phone, 'code' => $otp->code];
        return $this->success($data, 'success');
    }
    public function verifyOTP(LoginRequest $request)
    {
        $otp = OTP::wherecode($request->code)->get()->first();
        if ($otp->code == $request->code) {
            return $this->success([], 'success');
        } else {
            return $this->error_message('Wrong Code');
        }
    }
    public function resetPassword(PasswordRequest $request)
    {
        if ($request->has('phone')) {
            $otp = OTP::wherecode($request->code)->get()->first();
            if ($otp->code == $request->code) {
                $user = User::find($otp->phone)->update([
                    'password' => $request->password,
                ]);
                return $this->success([], 'success');
            } else {
                return $this->error_message('Wrong Code');
            }
        } else {
            $user = User::find(auth()->user()->id);
            if (!Hash::check($request->old_password, $user->password)) {
                return $this->error_message('Wrong Password');
            }
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return $this->success([], 'success');
        }
    }
    public function createDeviceToken(LoginRequest $request)
    {
        $id = Auth::id();
        User::findOrFail($id)->update([
            'device_token' => $request->device_token
        ]);
        return $this->success([], 'success');
    }
    public function deleteDeviceToken(LoginRequest $request)
    {
        $id = Auth::id();
        User::findOrFail($id)->update([
            'device_token' => null
        ]);
        return $this->success([], 'success');
    }

}
