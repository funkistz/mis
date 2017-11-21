<?php

namespace App\Traits;
use App\Models\SystemSetting;
use App\Models\MemberCard;
use Carbon\Carbon;

trait MemberCardTrait
{
    public function calculateDueDate()
    {
        $due = SystemSetting::where('field', 'member_card_due')->first()['value'];

        return Carbon::now()->addMonths($due);
    }

    public function cardPrefix()
    {
        $prefix = SystemSetting::where('field', 'member_card_prefix')->first()['value'];

        return $prefix;
    }

    public function cardPostfix()
    {
        $postfix = SystemSetting::where('field', 'member_card_postfix')->first()['value'];

        return $postfix;
    }

    public function incrementCardNumber()
    {
        $card_length = SystemSetting::where('field', 'member_card_length')->first()['value'];
        $latest_no = MemberCard::orderBy('card_no', 'DESC')->first()['card_no'];

        if(count($latest_no) <= 0){
          $card_latest_no = sprintf('%0' . $card_length . 'd', 1);
        }else{
          $card_latest_no = sprintf('%0' . $card_length . 'd', $latest_no + 1);
        }

        return $card_latest_no;
    }


}
