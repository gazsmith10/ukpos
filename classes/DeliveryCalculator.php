<?php

namespace App\Classes;

class DeliveryCalculator
{
    private $dispatchExceptions;
    private $deliveryExceptions;

    public function __construct(array $dispatchExceptions, array $deliveryExceptions)
    {
        $this->dispatchExceptions = $dispatchExceptions;
        $this->deliveryExceptions = $deliveryExceptions;
    }

    public function calculateEarliestDeliveryDate(\DateTime $orderDate, \DateTime $cutoffTime, DeliveryMethod $method)
    {

        if ($orderDate->format('H:i') > $cutoffTime->format('H:i')) {
            $orderDate->modify('+1 day');
        }

        // next valid dispatch date
        $dispatchDate = $this->getNextValidDispatchDate(clone $orderDate);

        // next valid delivery date
        $deliveryDate = $this->getNextValidDeliveryDate(clone $dispatchDate, $method);

        return $deliveryDate->format('Y-m-d');
    }

    private function getNextValidDispatchDate(\DateTime $date)
    {
        // lloop to find the next valid dispatch date
        while ($this->isException($date, $this->dispatchExceptions) || !$this->isDispatchDay($date)) {
            $date->modify('+1 day');
        }
        return $date;
    }

    private function getNextValidDeliveryDate(\DateTime $dispatchDate, DeliveryMethod $method)
    {
        // add days to dispatch date based on delivery method
        $dispatchDate->modify('+' . $method->daysAfterDispatch . ' days');

        // loop to find the next valid delivery date
        while ($this->isException($dispatchDate, $this->deliveryExceptions) || !$this->isDeliveryDay($dispatchDate, $method)) {
            $dispatchDate->modify('+1 day');
        }
        return $dispatchDate;
    }

    private function isDispatchDay(\DateTime $date)
    {
        // check if the date is a valid dispatch day
        $dayOfWeek = $date->format('N'); // 1 (Monday) to 7 (Sunday)
        return ($dayOfWeek <= 5); // Monday to Friday
    }

    private function isDeliveryDay(\DateTime $date, DeliveryMethod $method)
    {
        // check if the date is a valid delivery day based on the delivery method
        $dayOfWeek = $date->format('N'); // 1 (Monday) to 7 (Sunday)
        return ($dayOfWeek <= 5 && $method->allowsWeekdays) || 
               ($dayOfWeek == 6 && $method->allowsSaturday) || 
               ($dayOfWeek == 7 && $method->allowsSunday);
    }

    private function isException(\DateTime $date, array $exceptions)
    {
        // check if the date is in the list of exceptions
        return in_array($date->format('d/m/Y'), $exceptions);
    }
}
