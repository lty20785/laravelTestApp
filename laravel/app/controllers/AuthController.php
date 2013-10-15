<?php
class AuthController extends BaseController {

    public function showLogin()
    {
        // Check if we already logged in
        if (Auth::check())
        {
            // Redirect to homepage
            return Redirect::to('')->with('success', 'You are already logged in');
        }

        // Show the login page
        return View::make('auth/login');
    }

    public function doLogin()
    {
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        // Declare the rules for the form validation.
        $rules = array(
            'username'  => 'Required',
            'password'  => 'Required'
        );

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

        // Check if the form validates with success.
        if ($validator->passes())
        {
            // Try to log the user in.
            if (Auth::attempt($userdata))
            {
                // Redirect to homepage
                return Redirect::to('')->with('success', 'You have logged in successfully');
            }
            else
            {
                // Redirect to the login page.
                return Redirect::to('login')->withErrors(array('password' => 'Password invalid'))->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
        return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));

    }

    public function doLogout()
    {
        // Log out
        Auth::logout();

        // Redirect to homepage
        return Redirect::to('')->with('success', 'You are logged out');
    }

    public function showRegister()
    {
        if (Auth::check())
        {
            // Redirect to homepage
            return Redirect::to('')->with('success', 'You are already logged in');
        }

        // Show the login page
        return View::make('auth/register');
    }

    public function doRegister()
    {
        $userdata = array(
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        $rules = array(
            "username" => 'required|unique:users',
            "email" => 'required|unique:users|email',
            "password" => 'required'
            );

        $v = Validator::make($userdata, $rules);

        if ($v->fails()){
            return Redirect::to('auth/register')->with_errors($v)->withInput(Input::except('password'));
        }else{
            $user = new User;
            $user->username = $input['username'];
            $user->email = $input['email'];
            $user->password = $input['password'];
            $user->save();

        return Redirect::to('auth/login');
        }
    }
}
