<?php
require "vendor/autoload.php";
use app\ReadFileService;
use app\Notify;
use app\Sms;

date_default_timezone_set('Asia/Taipei'); // 設定時區


//TODO 讀取 csv 檔案
$readFileService = new ReadFileService();
$contracts = $readFileService->getList("order.csv");

//TODO 找出快到期的客戶
$notify = new Notify();
$dates = $notify->getNotifyDates([3, 5, 7, 14]);
$needNotifyOrder = $notify->getNotifyOrder($contracts, $dates);
$arrayNumber = count($needNotifyOrder);



for ($i = 0; $i < $arrayNumber; $i++) {

    $phoneNumber = $needNotifyOrder[$i]->phone;
    $name = $needNotifyOrder[$i]->name;
    $price = $needNotifyOrder[$i]->price;
    $item = $needNotifyOrder[$i]->item;
    $date = $needNotifyOrder[$i]->date;
    //判斷符合設定需傳送通知的內容
     $send_message = new Messages();
     $send_messages = $send_message->message($date);
    //$send_messages = $send_message->message($days, $date_list, $expirydate, $datas, $repeat_send, $today, $intoday, $inday, $x);
    (new Sms($phoneNumber, $name, $price, $item, $date))->sendSMS($send_messages);
}



//TODO 準備通知內容

function getMessage($days)
{
    return "提醒您,您的合約將於 " . $days . " 天後即將到期";
}

//TODO 寄信去提醒


//判斷傳送通知內容
class Messages
{
    public function message($expirydate)
    {
        //距離今天幾天到期

        $today = strtotime("now") / 86000;
        //距離今天幾天到期
        if ($expirydate - $today > 0) {
            $days = $expirydate - $today;
        } else {
            $days = $today - $expirydate;
        }

        $datas = date('Y-m-d');
        $message1 = "$datas" . "\n" . "\n" . '(要傳訊通知:提醒您,您的合約將於' . "$days" . '天後即將到期)';
        $message3 = "$datas" . "\n" . "\n" . '(要傳訊通知管理者:已過期的客戶，建議追蹤)';
        $message4 = '';
        //$content = '';


        if ($expirydate == $today)     //合約的到期日 與 設定的到期日
        {
            $content = $message1;
            return $content;
            //使用break，如有符合判別就停止迴圈繼續
        }

        if ($expirydate < $today)                //合約到期日已經過期
        {
            $content = $message3;
            return $content;
        } else

            //無符合$days天到期客戶資料
            return 8;
            //返回需傳送出的訊息內容

    }
}

//傳送訊息
class Send
{
    public function deliver($send_messages)
    {
        return $send_messages;
    }
}

/*物件結束*/

