<?php
namespace app;

//use app\Contract;
//use app\Notify;


class Sms
{

    protected $phoneNumber;
    protected $name;
    protected $price;
    protected $item;
    protected $date;

    function __construct($phoneNumber, $name, $price, $item, $date)
    {

        $this->phoneNumber = $phoneNumber;
        $this->name = $name;
        $this->price = $price;
        $this->item = $item;
        $this->date = $date;

    }

    public function sendSMS($content)
    {

        $username = "0960631656";
        $password = "0960631656";
//        $content = $this->name . "\r\n" . $this->phoneNumber . "\r\n" .  $this->price . "\r\n" . $this->item . "\r\n" .
//            $this->date . "\r\n" . "欠錢還錢";

        $data = array(
            'username' => $username,
            'password' => $password,
            'dstaddr' => $this->phoneNumber,
            'response' => '',
            'smbody' => iconv("UTF-8", "big5//TRANSLIT", $content));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.kotsms.com.tw/kotsmsapi-1.php?" . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        print "................ok寄出了......................";
    }

}
