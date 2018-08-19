<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->User = $user;
        $genders = User::getGenders();
        view()->share(compact('genders'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'required|mimes:jpeg,jpg,png|dimensions:width=100,height=100',
            'code' => 'required|unique:users',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'email.email' => 'Dữ liệu phải có định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'password.string' => 'Mật khẩu phải là chuỗi',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu nhập lại không chính xác',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.dimensions' => 'Ảnh không đúng kích thước',];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validate = $this->validator($request->all());
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->logout();
        return redirect('/login')->with('status', 'Chúng tôi đã gửi cho bạn mã kích hoạt. Kiểm tra email của bạn và nhấp vào liên kết để xác minh.');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'avatar' => $data['avatar']->store('avatars'),
                    'gender' => $data['gender'],
                    'birthday' => $data['birthday'],
                    'token' => str_random(40)
        ]);
        Mail::to($user->email)->send(new \App\Mail\VerifyMail($user));
        return $user;
    }

    public function verifyUser($token)
    {
        $user = User::where('token', $token)->first();
        if (isset($user)) {
            if (!$user->verified) {
                $user->verified = 1;
                $user->save();
                $status = "Email của bạn đã được xác nhận. Bây giờ bạn có thể đăng nhập";
            } else {
                $status = "Email của bạn đã được xác nhận. Bây giờ bạn có thể đăng nhập";
            }
        } else {
            return redirect('/login')->with('warning', "Rất tiếc, không thể xác định được email của bạn.");
        }

        return redirect('/login')->with('status', $status);
    }

}
