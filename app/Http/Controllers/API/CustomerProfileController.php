<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Base controller
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use App\Models\User;
use App\Models\CustomerProfile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    /**
     *  API Function to update user profile. 
    */
    public function updateProfile(Request $request)
    {
        // echo"<pre>"; print_r($request->all()); die;
        try {
            $request->validate([
                'full_name'    => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email,' . Auth::id(),
                'phone_number' => 'nullable|string|max:15|unique:users,phone,' . Auth::id(),
                'gender'       => 'nullable|in:male,female,other',
                'dob'          => 'nullable|date|before:today',
                'anniversary'  => 'nullable|date|after:dob',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max size 2MB
            ]);

            $user = Auth::user();
            $oldImage = $user->profile_image;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('profile_images', $imageName);
                $imageUrl = asset('storage/profile_images/' . $imageName);
                \Log::info('Image Path: ' . $imagePath);
                $user->profile_image = $imageUrl;
            }

            $user->update([
                'name'    => $request->full_name,
                'email'        => $request->email,
                'phone' => $request->phone_number,
                'gender'       => $request->gender
            ]);

            // Update or create customer profile
            $customerProfile = CustomerProfile::updateOrCreate(
                ['customer_id' => $user->id],
                [
                    'birthday' => $request->dob,
                    'anniversary' => $request->anniversary,
                ]
            );

            return response()->json(['message' => 'Profile updated successfully', 'user' => $user->load('customerProfile')], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * API Function for Update User status
     * 
    */
    public function updateStatus($user_id, Request $request)
    {
        try{
            $user = User::find($user_id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $validatedData = $request->validate([
                'status' => ['required', Rule::in(['pending', 'active', 'suspended'])],
            ]);

            // Check if status is actually changing
            if ($user->status === $validatedData['status']) {
                return response()->json(['message' => 'User status is already ' . $user->status], 400);
            }

            $user->status = $validatedData['status'];
            $user->save();

            return response()->json([
                'message' => 'User status updated successfully',
                'user' => $user
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     *  API Function for update Push Notification status of customer
    */
    public function pushNotificationUpdate(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        try {
            $user = Auth::user();
            $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
            if (!$customerProfile) {
                return response()->json([
                    'error' => 'Customer profile not found',
                ], 404);
            }
            $customerProfile->push_notification = $request->enabled ? '1' : '0';
            $customerProfile->save();

            return response()->json([
                'message' => 'Push notification setting updated successfully',
                'push_notification' => $customerProfile->push_notification,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update push notification setting',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     *  API Function for update Location 
    */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        try {
            $user = Auth::user();
            $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
            if (!$customerProfile) {
                return response()->json([
                    'error' => 'Customer profile not found',
                ], 404);
            }
            $customerProfile->location = $request->enabled ? '1' : '0';
            $customerProfile->save();

            return response()->json([
                'message' => 'Location updated successfully',
                'location' => $customerProfile->location,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update customer location',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     *  API Function for update Language 
    */
    public function updateCustomerLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required',
        ]);

        try {
            $user = Auth::user();
            $customerProfile = CustomerProfile::where('customer_id', $user->id)->first();
            if (!$customerProfile) {
                return response()->json([
                    'error' => 'Customer profile not found',
                ], 404);
            }
            $customerProfile->preferred_language = $request->language;
            $customerProfile->save();

            return response()->json([
                'message' => 'Language updated successfully',
                'language' => $customerProfile->preferred_language,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update customer location',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
