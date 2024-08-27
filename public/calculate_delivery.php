<?php
require_once '../vendor/autoload.php';

use App\Classes\CsvParser;
use App\Classes\DeliveryMethod;
use App\Classes\DeliveryCalculator;

// load data from csv
$deliveryMethodsData = CsvParser::parse('../delivery_methods.csv');

// get thee form data
$orderDateInput = $_POST['order-date'] ?? '';
$cutoffTimeInput = $_POST['cutoff-time'] ?? '';
$deliveryMethodName = $_POST['delivery-method'] ?? '';

if (empty($orderDateInput) || empty($cutoffTimeInput) || empty($deliveryMethodName)) {
    echo "Error: Missing required form data.";
    exit;
}

// find selected delivery method
$selectedMethodData = array_filter($deliveryMethodsData, function ($method) use ($deliveryMethodName) {
    return $method['Name'] === $deliveryMethodName;
});
$selectedMethod = new DeliveryMethod(reset($selectedMethodData));

$orderDate = new DateTime($orderDateInput);
$cutoffTime = new DateTime($cutoffTimeInput);

// pass file paths to the DeliveryCalculator class
$calculator = new DeliveryCalculator(
    file('../dispatch_exceptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
    file('../delivery_exceptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
);

// calculate earliest delivery date
$earliestDeliveryDate = $calculator->calculateEarliestDeliveryDate($orderDate, $cutoffTime, $selectedMethod);

echo "Earliest Delivery Date: " . htmlspecialchars($earliestDeliveryDate);
