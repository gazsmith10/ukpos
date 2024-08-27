<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Date Calculator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Delivery Date Calculator</h1>

    <form id="delivery-form">
        <label for="order-date">Order Date:</label>
        <input type="date" id="order-date" name="order-date" required>
        
        <label for="cutoff-time">Cutoff Time (24-hour format):</label>
        <input type="time" id="cutoff-time" name="cutoff-time" required>
        
        <label for="delivery-method">Delivery Method:</label>
        <select id="delivery-method" name="delivery-method" required>
            <!-- from CSV maybe? -->
        </select>

        <button type="submit">Calculate Earliest Delivery Date</button>
    </form>

    <div id="result">
        <h2>Earliest Delivery Date:</h2>
        <p id="delivery-date"></p>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
