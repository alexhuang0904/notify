<?php
namespace app;

class Notify {

    function getNotifyDates( $checkpoints )
    {
        $dates = [];
        foreach ($checkpoints as $checkpoint)
        {
            $dates[] = date('Y-m-d',strtotime("today + " . $checkpoint . " days" ));
        }

        return $dates;
    }

    function getNotifyOrder($contracts, $dates)
    {
        $needNotifyOrder = [];

        foreach ($contracts as $contract)
        {
            foreach ($dates as $date)
            {
                if(strtotime($contract->date) == strtotime($date))
                {
                    $needNotifyOrder[] = $contract;
                }
            }
        }

        return $needNotifyOrder;
    }
}