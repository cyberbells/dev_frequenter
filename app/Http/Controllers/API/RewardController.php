<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;




class RewardController extends Controller
{
    public function generateRedemptionQrCode($rewardId)
    {
        $customerId = Auth::id();

        // Fetch reward details
        $reward = DB::table('rewards')->where('reward_id', $rewardId)->first();
        if (!$reward) {
            abort(404, 'Reward not found');
        }

        // Check for existing pending redemption
        $existingRedemption = DB::table('reward_redemptions')
            ->where('customer_id', $customerId)
            ->where('reward_id', $rewardId)
            ->where('status', 'pending')
            ->first();

        if ($existingRedemption) {
            $encryptedPayload = Crypt::encryptString(json_encode([
                'type' => 'reward_redemption',
                'customer_id' => $customerId,
                'reward_id' => $rewardId,
                'redemption_code' => $existingRedemption->redemption_code,
            ]));
            $qrCode = QrCode::size(300)->generate($encryptedPayload);

            return view('customer.reward-qr', compact('qrCode'));
        }

        // Create new redemption entry
        $redemptionCode = Str::random(10);
        DB::table('reward_redemptions')->insert([
            'customer_id' => $customerId,
            'reward_id' => $rewardId,
            'business_id' => $reward->business_id,
            'points_redeemed' => $reward->points_required,
            'status' => 'pending',
            'redemption_code' => $redemptionCode,
            'created_at' => now(),
        ]);

        $encryptedPayload = Crypt::encryptString(json_encode([
            'type' => 'reward_redemption',
            'customer_id' => $customerId,
            'reward_id' => $rewardId,
            'redemption_code' => $redemptionCode,
        ]));
        $qrCode = QrCode::size(300)->generate($encryptedPayload);

        return view('customer.reward-qr', compact('qrCode'));
    }

    public function generateRedemptionQrCodeApi(Request $request)
    {
        $validated = $request->validate([
            'reward_id' => 'required|integer',
        ]);

        $customerId = Auth::id();
        $rewardId = $validated['reward_id'];

        // Fetch reward details
        $reward = DB::table('rewards')->where('reward_id', $rewardId)->first();
        if (!$reward) {
            return response()->json(['error' => 'Reward not found'], 404);
        }

        // Check for existing pending redemption
        $existingRedemption = DB::table('reward_redemptions')
            ->where('customer_id', $customerId)
            ->where('reward_id', $rewardId)
            ->where('status', 'pending')
            ->first();

        if ($existingRedemption) {
            $encryptedPayload = Crypt::encryptString(json_encode([
                'type' => 'reward_redemption',
                'customer_id' => $customerId,
                'reward_id' => $rewardId,
                'redemption_code' => $existingRedemption->redemption_code,
            ]));
            $qrCode = base64_encode(QrCode::size(300)->generate($encryptedPayload));

            return response()->json([
                'qr_code' => $qrCode,
                'message' => 'Existing redemption reused.',
            ], 200);
        }

        // Create new redemption entry
        $redemptionCode = Str::random(10);
        DB::table('reward_redemptions')->insert([
            'customer_id' => $customerId,
            'reward_id' => $rewardId,
            'business_id' => $reward->business_id,
            'points_redeemed' => $reward->points_required,
            'status' => 'pending',
            'redemption_code' => $redemptionCode,
            'created_at' => now(),
        ]);

        $encryptedPayload = Crypt::encryptString(json_encode([
            'type' => 'reward_redemption',
            'customer_id' => $customerId,
            'reward_id' => $rewardId,
            'redemption_code' => $redemptionCode,
        ]));
        $qrCode = base64_encode(QrCode::size(300)->generate($encryptedPayload));

        return response()->json([
            'qr_code' => $qrCode,
            'message' => 'New redemption created.',
        ], 201);
    }

}
