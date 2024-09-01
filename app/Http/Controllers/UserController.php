<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Twilio\Rest\Client;

class UserController extends Controller
{
    public function index()
    {
        // Admins see all users; salespersons see only the users they created.
        if (Auth::user()->hasRole('admin')) {
            $users = User::all();
        } elseif (Auth::user()->hasRole('salesperson')) {
            $users = User::where('created_by', Auth::id())->get();
        } else {
            return abort(403, 'Unauthorized action.');
        }

        return view('admin.profile.userprofile', compact('users'));
    }

    public function create()
    {
        // Only admins and salespersons can create users
        if (Auth::user()->hasRole(['admin', 'salesperson'])) {
            // Admins can assign any role; salespersons should only assign 'user'
            $roles = Auth::user()->hasRole('admin') 
                ? Role::all() 
                : Role::where('name', 'user')->get();
            
            return view('users.create', compact('roles'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|string|max:15|unique:users', // Validate phone number as primary identifier
            'email' => 'nullable|email|unique:users', // Email is nullable
            'password' => 'required|min:8',
            'roles' => 'required|array',
        ]);

        $userCount = User::count();

        // Ensure that only the first user created is an admin, subsequent users are not
        if ($userCount == 0) {
            $role = 'admin';
        } else {
            $role = $request->roles[0];
        }

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email, // Email is optional
            'password' => Hash::make($request->password),
            'created_by' => Auth::id(), // Track who created the user
        ]);

        $user->assignRole($role);

        // Generate a verification code
        $verificationCode = rand(100000, 999999);

        // Save the verification code to the user's record
        $user->verification_code = $verificationCode;
        $user->save();

        // Send the verification code via SMS
        $this->sendSmsVerification($user->phone_number, $verificationCode);

        return redirect()->route('admin.profile.userprofile')->with('success', 'User created successfully. A verification code has been sent to the user\'s phone number.');
    }

    /**
     * Send SMS verification code to the user's phone number.
     *
     * @param string $phoneNumber
     * @param int $verificationCode
     */
    protected function sendSmsVerification($phoneNumber, $verificationCode)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        $twilio = new Client($sid, $token);

        $twilio->messages->create($phoneNumber, [
            'from' => $from,
            'body' => "Your verification code is: $verificationCode"
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:15',
            'verification_code' => 'required|integer',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user && $user->verification_code == $request->verification_code) {
            $user->is_verified = true;
            $user->save();

            return redirect()->route('home')->with('success', 'Phone number verified successfully!');
        }

        return redirect()->back()->withErrors(['verification_code' => 'Invalid verification code.']);
    }

    public function show(User $user)
    {
        // Admins can view any user; salespersons can only view users they created
        if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('salesperson') && $user->created_by == Auth::id())) {
            return view('users.show', compact('user'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function edit(User $user)
    {
        // Admins can edit any user; salespersons can only edit users they created
        if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('salesperson') && $user->created_by == Auth::id())) {
            $roles = Auth::user()->hasRole('admin') 
                ? Role::all() 
                : Role::where('name', 'user')->get();

            return view('users.edit', compact('user', 'roles'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, User $user)
    {
        // Admins can update any user; salespersons can only update users they created
        if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('salesperson') && $user->created_by == Auth::id())) {
            $request->validate([
                'name' => 'required',
                'phone_number' => 'required|string|max:15|unique:users,phone_number,' . $user->id, // Unique validation for phone number
                'email' => 'nullable|email|unique:users,email,' . $user->id, // Email is optional
                'roles' => 'required|array',
            ]);

            $user->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email, // Email is optional
            ]);

            $user->syncRoles($request->roles);

            return redirect()->route('admin.profile.userprofile')->with('success', 'User updated successfully.');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function destroy(User $user)
    {
        // Admins can delete any user; salespersons can only delete users they created
        if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('salesperson') && $user->created_by == Auth::id())) {
            $user->delete();
            return redirect()->route('admin.profile.userprofile')->with('success', 'User deleted successfully.');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
