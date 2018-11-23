<?php
namespace app;

class Contract {

    public $name;
    public $phone;
    public $price;
    public $item;
    public $date;

    public function __construct( $name, $phone, $price, $item, $date )
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->price = $price;
        $this->item = $item;
        $this->date = $date;
    }
}