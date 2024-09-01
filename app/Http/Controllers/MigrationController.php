<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function show()
    {
        return view('auth.migrate');
    }

    public function migrate(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if (!$userId) {
            return redirect()->route('login')->withErrors('User ID not found.');
        }

        $databaseName = 'shop_' . $userId;

        Config::set("database.connections.user_db_$userId", [
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

        DB::statement("CREATE DATABASE $databaseName");

        // Run migrations in the new database
        Artisan::call('migrate', ['--database' => "user_db_$userId", '--path' => 'database/migrations']);

        return redirect('/dashboard')->with('status', 'Tables migrated successfully.');
    }
}
