<?php


namespace App\Modules\Panel\Controllers;


use App\Modules\Billing\Models\ModulePurchase;
use App\Modules\Domains\Models\Domains;
use App\Modules\Panel\Models\User;
use Carbon\Carbon;

trait StatisticTrait
{
    public function activeNotifiactionUsers()
    {
        $activeDomainIds = ModulePurchase::where([
            'status' => 1
        ])->pluck('domain_id');

        $activeUserIds = Domains::whereIn('id', $activeDomainIds)
            ->groupBy('user_id')
            ->pluck('user_id');

        $users = User::whereIn('id', $activeUserIds)->get();
        return $users;
    }

    public function activeTrials()
    {
        $prevWeek = Carbon::now()->subWeek()->format('Y-m-d');
        $activeTrialUsers = User::whereTrial(1)->where('created_at', '>=', $prevWeek)->count();
        return $activeTrialUsers;
    }
}