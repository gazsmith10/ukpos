<?php

namespace App\Classes;

class DeliveryCalculator
{
    private $dispatchExceptions;
    private $deliveryExceptions;
    private $dispatchWeekdays;
    private $dispatchSaturday;
    private $dispatchSunday;

    public function __construct(array $dispatchExceptions, array $deliveryExceptions, bool $dispatchWeekdays, bool $dispatchSaturday, bool $dispatchSunday)
    {
        $this->dispatchExceptions = $dispatchExceptions;
        $this->deliveryExceptions = $deliveryExceptions;
        $this->dispatchWeekdays = $dispatchWeekdays;
        $this->dispatchSaturday = $dispatchSaturday;
        $this->dispatchSunday = $dispatchSunday;
    }

    public function calculateEarliestDeliveryDate(\DateTime $orderDate, \DateTime $cutoffTime, DeliveryMethod $method)
    {
        if ($orderDate->format('H:i') > $cutoffTime->format('H:i')) {
            $orderDate->modify('+1 day');
        }

        // find the next valid dispatch date
        $dispatchDate = $this->getNextValidDispatchDate(clone $orderDate);

        // find the next valid delivery date
        $deliveryDate = $this->getNextValidDeliveryDate(clone $dispatchDate, $method);

        return $deliveryDate->format('Y-m-d');
    }

    private function getNextValidDispatchDate(\DateTime $date)
    {
        while ($this->isException($date, $this->dispatchExceptions) || !$this->isDispatchDay($date)) {
            $date->modify('+1 day');
        }
        return $date;
    }

    private function getNextValidDeliveryDate(\DateTime $dispatchDate, DeliveryMethod $method)
    {
        $dispatchDate->modify('+' . $method->daysAfterDispatch . ' days');
        while ($this->isException($dispatchDate, $this->deliveryExceptions) || !$this->isDeliveryDay($dispatchDate, $method)) {
            $dispatchDate->modify('+1 day');
        }
        return $dispatchDate;
    }

    private function isDispatchDay(\DateTime $date)
    {
        $dayOfWeek = $date->format('N'); // 1 (Monday) to 7 (Sunday)
        $isDispatchDay = ($dayOfWeek <= 5 && $this->dispatchWeekdays) || 
                         ($dayOfWeek == 6 && $this->dispatchSaturday) || 
                         ($dayOfWeek == 7 && $this->dispatchSunday);

        // echo "Checking if dispatch day: {$date->format('Y-m-d')} - Dispatch allowed: " . ($isDispatchDay ? 'Yes' : 'No') . "<br>";
        
        return $isDispatchDay;
    }
    
    private function isDeliveryDay(\DateTime $date, DeliveryMethod $method)
    {
        $dayOfWeek = $date->format('N'); // 1 (Monday) to 7 (Sunday)
        return ($dayOfWeek <= 5 && $method->allowsWeekdays) || 
               ($dayOfWeek == 6 && $method->allowsSaturday) || 
               ($dayOfWeek == 7 && $method->allowsSunday);
    }

    private function isException(\DateTime $date, array $exceptions)
    {
        return in_array($date->format('d/m/Y'), $exceptions);
    }
}
