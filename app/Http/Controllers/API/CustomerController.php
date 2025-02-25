<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB; // Import DB Facade

class CustomerController extends Controller
{
    // Show the login form (for web)
    public function showLoginForm()
    {
        return view('customer.login');
    }

    public function showRegistrationForm()
    {
        return view('customer.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'zip_code' => 'required|string|max:10',
            'radius' => 'nullable|integer',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        // Create the customer profile
        CustomerProfile::create([
            'customer_id' => $user->user_id,
            'zip_code' => $validated['zip_code'],
            'radius' => $validated['radius'] ?? 5,
            'address_line1' => $validated['address_line1'],
            'address_line2' => $validated['address_line2'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
        ]);

        return redirect()->route('customer.register')->with('success', 'Registration successful!');
    }
    // Handle login (supports both web and API)
    public function handleLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Update last_login_at
            $user->last_login_at = now();
            $user->save();

            if ($request->expectsJson()) {
                // For API Login: Return Sanctum token
                $token = $user->createToken($user->role . '-token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user,
                    'role' => $user->role, // Include role in API response
                ], 200);
            }

            // For Web Login: Role-based redirection
            $request->session()->regenerate();

            if ($user->role === 'business') {
                return redirect()->route('business.dashboard');
            } elseif ($user->role === 'customer') {
                return redirect()->route('customer.dashboard');
            }

            // Default: If role is not set properly
            Auth::logout();
            return back()->with('error', 'User role is invalid.');
        }

        if ($request->expectsJson()) {
            // For API: Unauthorized Response
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // For Web: Return to login form with error
        return back()->with('error', 'Invalid login credentials.');
    }

    // Customer Dashboard View (web only)
    public function dashboard(Request $request)
    {
        return view('customer.dashboard', ['customer' => Auth::user()]);
    }

    // Handle Logout (supports both web and API)
    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            // For API: Revoke Sanctum token
            $request->user()->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        // For Web: Logout and invalidate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function generateEncryptedQrCode()
    {
        // Get the authenticated user's ID (customer ID)
        $userId = Auth::id(); // This retrieves the logged-in user's user_id
        // Create payload
        $payload = [
            "type" => "customer_checkin",
            "customer_id" => $userId
        ];

        // Encrypt payload
        $encryptedPayload = Crypt::encryptString(json_encode($payload));

        // Generate QR code
        $qrCode = QrCode::size(300)->generate($encryptedPayload);

        // Generate text code (Base64-encoded payload)
        $textCode = base64_encode($encryptedPayload);

        // Return view with QR code and text code
        return view('customer.qr-code', compact('qrCode', 'textCode'));
    }

    public function generateEncryptedQrCodeApi()
    {
        // Get the authenticated user's ID (customer ID)
        $userId = Auth::id();

        // Create payload
        $payload = [
            "type" => "customer_checkin",
            "customer_id" => $userId
        ];

        // Encrypt payload
        $encryptedPayload = Crypt::encryptString(json_encode($payload));

        // Generate QR Code as PNG
        $qrCode = QrCode::format('png')->size(300)->generate($encryptedPayload);

        // Generate text code (Base64-encoded payload)
        $textCode = base64_encode($encryptedPayload);

        // Return JSON response
        return response()->json([
            'message' => 'Customer QR code generated successfully.',
            'qr_code' => 'data:image/png;base64,' . base64_encode($qrCode),
            'text_code' => $textCode
        ], 200);
    }

    public function searchBusinesses(Request $request)
    {
        $query = $request->get('query', '');

        // Search businesses by name or category
        $businesses = DB::table('business_profiles')
            ->where('business_name', 'LIKE', "%{$query}%")
            ->orWhere('industry_type', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('customer.search', compact('businesses', 'query'));
    }

    public function viewBusinessProfile($businessId)
    {
        $business = DB::table('business_profiles')->where('business_id', $businessId)->first();

        $rewards = DB::table('rewards')->where('business_id', $businessId)->get();
        $contests = DB::table('contests')->where('business_id', $businessId)->get(); // If contests exist

        return view('customer.business-profile', compact('business', 'rewards', 'contests'));
    }

    public function apiDashboard(Request $request)
    {
        try {
            $user = $request->user();
            $profile = $user->profile; // Assuming `profile` is a relationship in the User model.

            // 1. Fetch City and State
            $city = $profile->city ?? 'Unknown';
            $state = $profile->state ?? 'Unknown'; // Assuming state exists in the profile

            // 2. Fetch Total Check-Ins
            $checkIns = DB::table('customer_business_interactions')
                ->where('customer_id', $user->user_id)
                ->where('interaction_type', 'check_in')
                ->count();

            // 3. Fetch Total Businesses
            $businessesCount = DB::table('customer_business_interactions')
                ->where('customer_id', $user->user_id)
                ->distinct('business_id')
                ->count('business_id');

            // 4. Fetch Frequent Businesses
            $frequentBusinesses = DB::table('customer_business_interactions')
                ->where('customer_id', $user->user_id)
                ->join('business_profiles', 'customer_business_interactions.business_id', '=', 'business_profiles.business_id')
                ->select('business_profiles.business_name')
                ->groupBy('business_profiles.business_name')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(4)
                ->pluck('business_name')
                ->toArray();

            return response()->json([
                'name' => $user->name,
                'city' => "$city, $state",
                'reward_points' => $profile->points_balance ?? 0,
                'businesses_count' => $businessesCount,
                'check_ins' => $checkIns,
                'offers' => 5, // Placeholder for now
                'frequent_businesses' => $frequentBusinesses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch dashboard data', 'error' => $e->getMessage()], 500);
        }
    }
}
