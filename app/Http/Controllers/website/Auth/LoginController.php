<?php

namespace App\Http\Controllers\website\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Api\CategoryRepository;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $data['type'] = "login";
        $data['categories'] = $this->list_cats($request);
        return view('website-views.auth.index', $data, compact('data'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (auth('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            return redirect()->route('home.index');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        return redirect()->route('home.index');
    }

    public function list_cats(Request $request)
    {


        try {
            $cat = new CategoryRepository();
            $categories = $cat->list_cats($request);

            return $categories;

        } catch (\Exception $e) {
            return [];
        }
    }


    public function showregister(Request $request){
        $data['type'] = "register";
        $data['categories'] = $this->list_cats($request);
        return view('website-views.auth.index', $data, compact('data'));
    }
    public function register(RegisterRequest $request)
    {
        $validated = $request->all();
        $validated ['active'] = 0;
        $validated['password'] = Hash::make($validated['password']);
        unset($validated['checkpolicy']);
        try {
            $user = User::create($validated);

        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Credentials does not match.']);


        }
        return redirect()->route('home.index')->with('success', __('Registration successful!'));

    }
}
