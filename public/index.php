<?php
require_once '../vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Date Calculator</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/form-handler.js" defer></script>
</head>
<body>
    <h1>Delivery Date Calculator</h1>
    <form id="delivery-form">
        <label for="order-date">Order Date:</label>
        <input type="date" id="order-date" name="order-date" required>
        
        <label for="order-time">Order Time (24-hour format):</label>
        <input type="time" id="order-time" name="order-time" required>
        
        <label for="delivery-method">Delivery Method:</label>
        <select id="delivery-method" name="delivery-method" required>
            <?php
            use App\Classes\CsvParser;

            $deliveryMethods = CsvParser::parse('../delivery_methods.csv');
            foreach ($deliveryMethods as $method) {
                echo "<option value=\"{$method['Name']}\">{$method['Name']}</option>";
            }
            ?>
        </select>

        <button type="submit">Calculate Earliest Delivery Date</button>
    </form>
    
    <div id="result">
    </div>
</body>
</html>
