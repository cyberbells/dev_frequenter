<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerDashboardController extends Controller
{
    public function redemptionQrCode($rewardId)
    {
        $customerId = Auth::id();

        // Fetch reward details
        $reward = DB::table('rewards')->where('reward_id', $rewardId)->first();
        if (!$reward) {
            abort(404, 'Reward not found');
        }

        $redemption = DB::table('reward_redemptions')
            ->where('customer_id', $customerId)
            ->where('reward_id', $rewardId)
            ->where('status', 'pending')
            ->first();

        if (!$redemption) {
            abort(404, 'Redemption not initiated');
        }

        $payload = [
            'type' => 'reward_redemption',
            'customer_id' => $customerId,
            'reward_id' => $rewardId,
            'business_id' => $reward->business_id,
            'redemption_code' => $redemption->redemption_code,
            'points_redeemed' => $reward->points_required,
            'reward_name' => $reward->reward_name,
        ];

        $encryptedPayload = Crypt::encryptString(json_encode($payload));
        $qrCode = QrCode::size(300)->generate($encryptedPayload);

        return view('customer.reward-qr', compact('qrCode', 'reward'));
    }
}
