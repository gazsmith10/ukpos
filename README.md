**Delivery Date Calculator**
This project calculates the earliest possible delivery date for orders based on delivery methods and exceptions. It uses a web form to get order details and updates the date based on various factors.

**Files**
index.php: The page with the form.
calculate_delivery.php: Processes the form submission and calculates the delivery date.
delivery_methods.csv: Defines different delivery methods and their rules.
dispatch_exceptions.txt: Lists dates when the warehouse doesn’t dispatch orders.
delivery_exceptions.txt: Lists dates when deliveries can’t be made.

**Updating Delivery Methods**
Open delivery_methods.csv: This file contains delivery method details and each row represents a delivery method. 

Name: Delivery method name.
Allows_Weekdays: "Yes" or "No".
Allows_Saturday: "Yes" or "No".
Allows_Sunday: "Yes" or "No".
Days_After_Dispatch: How many days after dispatch delivery will occur.

