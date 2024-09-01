<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Check if there are existing users
        $userCount = User::count();
        
        // Pass the user count to the view
        return view('auth.register', ['userCount' => $userCount]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Check if this is the first user
        $userCount = User::count();
        $isAdminRegistration = ($userCount == 0);

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Only validate shop details if it's not the first user (not admin)
            'shop_count' => $isAdminRegistration ? 'nullable' : 'required|integer|min:1',
            'shop_names' => $isAdminRegistration ? 'nullable' : 'required|array',
            'shop_addresses' => $isAdminRegistration ? 'nullable' : 'required|array',
        ]);

        // Store registration data temporarily in the session
        Session::put('registration_data', $request->all());

        // Redirect to the verification page
        return redirect()->route('verification.show');
    }

    /**
     * Display the verification view.
     */
    public function showVerificationForm()
    {
        return view('auth.verification');
    }

    /**
     * Handle the verification process.
     */
    public function verifyOrSkip(Request $request)
    {
        // Implement actual verification logic here.
        $isVerified = true; // Replace with actual verification logic

        if ($isVerified) {
            return $this->completeRegistration();
        }

        return redirect()->route('verification.show')->withErrors('Verification failed.');
    }

    /**
     * Complete the registration process after verification.
     */
    protected function completeRegistration()
    {
        // Retrieve the registration data from the session
        $registrationData = Session::get('registration_data');
        if (!$registrationData) {
            return redirect()->route('register')->withErrors('Registration data not found.');
        }

        // Wrap the user creation and migration in a transaction
        return DB::transaction(function () use ($registrationData) {
            // Step 1: Create the user
            $user = User::create([
                'name' => $registrationData['name'],
                'phone_number' => $registrationData['phone_number'],
                'email' => $registrationData['email'],
                'password' => Hash::make($registrationData['password']),
            ]);

            // Step 2: Assign role based on the registration type
            $isAdminRegistration = User::count() == 1;
            if ($isAdminRegistration) {
                if (!$this->roleExists('admin')) {
                    return redirect()->route('register')->withErrors('Admin role does not exist.');
                }
                $user->assignRole('admin');
            } else {
                if (!$this->roleExists('user')) {
                    return redirect()->route('register')->withErrors('User role does not exist.');
                }
                $user->assignRole('user');

                // Step 3: Create a unique database for the user (shop owner)
                $databaseName = 'shop_' . $user->id;

                // Check if the database already exists
                $databaseExists = DB::select("SHOW DATABASES LIKE '$databaseName'");
                if (empty($databaseExists)) {
                    DB::statement("CREATE DATABASE $databaseName");
                }

                // Configure the new database connection for this user
                $this->setDatabaseConnection($databaseName);

                // Debugging: Log to confirm the database connection
                Log::info('Database connection set for migration: ' . $databaseName);

                // Run migrations in the new database
                try {
                    $output = Artisan::call('migrate', ['--database' => 'user_db']);
                    Log::info('Migration output: ' . $output);
                } catch (\Exception $e) {
                    Log::error('Migration failed: ' . $e->getMessage());
                    return redirect()->route('register')->withErrors('Migration failed. Please try again.');
                }

                // Insert shops into the new database
                foreach ($registrationData['shop_names'] as $index => $shopName) {
                    DB::connection('user_db')->table('shops')->insert([
                        'name' => $shopName,
                        'address' => $registrationData['shop_addresses'][$index],
                        'owner_id' => $user->id,
                    ]);
                }

                // Reset the connection back to the default database
                $this->resetDatabaseConnection();
            }

            event(new Registered($user));

            Auth::login($user);

            // Clear the registration data from the session
            Session::forget('registration_data');

            return $isAdminRegistration ? redirect('/admin/dashboard') : redirect('/dashboard');
        });
    }

    /**
     * Set the database connection for a specific user's database.
     *
     * @param string $databaseName
     */
    protected function setDatabaseConnection(string $databaseName)
    {
        Config::set("database.connections.user_db", [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $databaseName,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);

        DB::purge('user_db'); // Clear any previous connection
        DB::setDefaultConnection('user_db'); // Set the new connection as the default
    }

    /**
     * Reset the database connection to the default configuration.
     */
    protected function resetDatabaseConnection()
    {
        DB::purge('user_db'); // Clear the user_db connection
        DB::setDefaultConnection(env('DB_CONNECTION', 'mysql')); // Reset to the default connection
    }

    /**
     * Check if a role exists in the database.
     *
     * @param string $roleName
     * @return bool
     */
    protected function roleExists(string $roleName): bool
    {
        return DB::table('roles')->where('name', $roleName)->exists();
    }
}
