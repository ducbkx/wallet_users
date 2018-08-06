<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->User = $user;
        $genders = User::getGenders();
        view()->share(compact('genders'));
    }

    public function information()
    {
        $users = User::where('email', Auth::user()->email)->paginate(5);
        return view('user.information', ['users' => $users]);
    }

    public function showForm()
    {
        return view('auth.passwords.change_password');
    }

    /**
     * Change password
     * 
     * @param Request $request
     * @return view
     */
    public function postChange(Request $request)
    {
        $rules = [
            'current_password' => 'required|min:8|old_password:' . Auth::user()->password,
            'password' => 'required|min:8|different:current_password|confirmed',
        ];
        $messages = [
            'min' => 'Mật khẩu phải dài hơn :min ký tự',
            'old_password' => 'Mật khẩu hiện tại không chính xác',
            'confirmed' => 'Mật khẩu nhập lại không khớp',
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ',
        ];

        $request->validate($rules, $messages);


        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            return redirect()->route('home')->with('status', 'Bạn đã đổi mật khẩu thành công');
            ;
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.editInformation', compact('user'));
    }

    public function update(Request $request, $id)
    {
        
        $user = User::find($id);
        $rules = [
            'name' => 'required|string|max:255',
            'avatar' => 'required|mimes:jpeg,jpg,png|dimensions:width=100,height=100',
            'code' => 'required|unique:users',
        ];
        $messages = [
            'required' => 'Trường không được bỏ trống',
            'name.string' => 'Dữ liệu phải là chuỗi',
            'email.email' => 'Dữ liệu phải có định dạng email',
            'email.unique' => 'Email đã tồn tại',
            'avatar.mimes' => 'Ảnh không đúng định dạng',
            'avatar.dimensions' => 'Ảnh không đúng kích thước',];
        if ($user->email != $request->get('email')) {
            $rules['email'] = 'required|email|unique:users';
        }
        
        ;
        dd($request->validate($rules, $messages));
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->avatar = $request->file('avatar')->store('avatars');
        $user->birthday = $request->birthday;
        

        if ($user->save()) {
            return redirect()->route('information');
        }
    }

}
