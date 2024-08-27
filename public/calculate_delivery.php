<?php
require_once '../vendor/autoload.php';

use App\Classes\CsvParser;
use App\Classes\DeliveryMethod;
use App\Classes\DeliveryCalculator;

// load data from CSV
$deliveryMethodsData = CsvParser::parse('../delivery_methods.csv');
$warehouseDispatchData = CsvParser::parse('../warehouse_dispatch.csv');

// get the form data
$orderDateInput = $_POST['order-date'] ?? '';
$cutoffTimeInput = $_POST['cutoff-time'] ?? '';
$deliveryMethodName = $_POST['delivery-method'] ?? '';

if (empty($orderDateInput) || empty($cutoffTimeInput) || empty($deliveryMethodName)) {
    echo "Error: Missing required form data.";
    exit;
}

// ind selected delivery method
$selectedMethodData = array_filter($deliveryMethodsData, function ($method) use ($deliveryMethodName) {
    return $method['Name'] === $deliveryMethodName;
});
$selectedMethod = new DeliveryMethod(reset($selectedMethodData));

// load warehouse dispatch rules
$dispatchWeekdays = $dispatchSaturday = $dispatchSunday = false;
foreach ($warehouseDispatchData as $rule) {
    if ($rule['Day'] === 'Weekday') {
        $dispatchWeekdays = $rule['Dispatch'] === 'Yes';
    } elseif ($rule['Day'] === 'Saturday') {
        $dispatchSaturday = $rule['Dispatch'] === 'Yes';
    } elseif ($rule['Day'] === 'Sunday') {
        $dispatchSunday = $rule['Dispatch'] === 'Yes';
    }
}

$orderDate = new DateTime($orderDateInput);
$cutoffTime = new DateTime($cutoffTimeInput);

// pass file paths to the DeliveryCalculator class
$calculator = new DeliveryCalculator(
    file('../dispatch_exceptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
    file('../delivery_exceptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
    $dispatchWeekdays,
    $dispatchSaturday,
    $dispatchSunday
);

// calculate earliest delivery date
$earliestDeliveryDate = $calculator->calculateEarliestDeliveryDate($orderDate, $cutoffTime, $selectedMethod);

// format the date in UK format (DD/MM/YYYY)
$earliestDeliveryDateUK = (new DateTime($earliestDeliveryDate))->format('d/m/Y');

echo "Earliest Delivery Date: " . htmlspecialchars($earliestDeliveryDateUK);
