<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
	protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
		$this->middleware('guest');

		$this->userRepository = $userRepository;
    }

	protected function index() {
		return view('auth.register');
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $customer_type)
    {
		if($customer_type == 'individual') {
			return Validator::make($data, [
				'first_name' => ['required', 'string', 'min:2'],
				'last_name' => ['required', 'string', 'min:2'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				'password' => ['required', 'min:6', 'confirmed'],
				'dob' => ['required', 'date']
			]);
		}else if ($customer_type == 'corporate') {
			return Validator::make($data, [
				'first_name' => ['required', 'string', 'min:2'],
				'last_name' => ['required', 'string', 'min:2'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				'password' => ['required', 'string', 'min:6', 'confirmed'],
				'business_name' => ['required', 'string'],
				'trn' => ['required', 'min:9', 'max:11']
			]);

		}

		return null;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function store(Request $request)
    {
		$validator = $this->validator($request->all(), $request->user_type);

		if(empty($validator))
			return redirect()->back(400);

		if($validator->fails())
			return redirect()->back()->withErrors($validator->errors());

		$result = $this->userRepository->store($request->all(), $request->user_type);

		if($result){
			return redirect()->route('home');
		}else{
			return redirect()->back()->withErrors(
				collect(['There was an issue signing up user.'])
			);
		}

    }
}
