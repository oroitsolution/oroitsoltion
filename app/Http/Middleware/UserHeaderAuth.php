<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserHeaderAuth
{


        public function handle(Request $request, Closure $next)
        {
            $clientId = $request->header('X-Client-Id');
            $secretId = $request->header('X-Secret-Id');

            // Check if required headers are present
            if (empty($clientId) || empty($secretId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing authentication headers'
                ], 401);
            }

            // Validate credentials against the database
            $user = DB::table('clints')->where('client_id', $clientId)->where('secret_id', $secretId)->where('status','active')->first();

            if ($user === NULL || $user === null ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your Header API Status is Not Active! Contact to Admin'
                ], 401);
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }
           
            // if (!$user) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Invalid credentials'
            //     ], 401);
            // }
        

            // Attach authenticated user to request
            $request->attributes->set('auth_user', $user);
            return $next($request);
        }

}
