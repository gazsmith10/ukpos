<?php

namespace App\Classes;

class DeliveryMethod
{
    public $name;
    public $allowsWeekdays;
    public $allowsSaturday;
    public $allowsSunday;
    public $daysAfterDispatch;

    public function __construct($data)
    {
        $this->name = $data['Name'];
        $this->allowsWeekdays = $data['Allows_Weekdays'] === 'Yes';
        $this->allowsSaturday = $data['Allows_Saturday'] === 'Yes';
        $this->allowsSunday = $data['Allows_Sunday'] === 'Yes';
        $this->daysAfterDispatch = (int)$data['Days_After_Dispatch'];
    }
}
