<?php

namespace App\Services;


use App\Model\Marketing;

class MarketingService
{
    /**
     * Get all Marketings
     *
     * @return $marketings
     */
    public function getAllMarketingByStatus($status=false)
    {
        $marketings = Marketing::query()
                                ->where('marketing_status',$status)
                                ->get();
        return $marketings;
    }
}