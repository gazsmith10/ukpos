**Delivery Date Calculator**

    This project calculates the earliest possible delivery date for orders based on delivery methods and exceptions. 
    It uses a web form to get order details and updates the date based on various factors.

**Files**
    
    index.php: The page with the form.
    
    calculate_delivery.php: Processes the form submission and calculates the delivery date.
    
    dispatch_exceptions.txt: Lists dates when the warehouse doesnt dispatch orders.
    
    delivery_exceptions.txt: Lists dates when deliveries cant be made.

    warehouse_dispatch.csv: Defines settings for Warehouse Dispatch.

    delivery_methods.csv: Defines different delivery methods and their rules.

**Updating Delivery Methods**

    delivery_methods.csv this file contains delivery method details and each row represents a delivery method. 

    Name: Delivery method name.
    Allows_Weekdays: "Yes" or "No".
    Allows_Saturday: "Yes" or "No".
    Allows_Sunday: "Yes" or "No".
    Days_After_Dispatch: How many days after dispatch delivery will occur.
    Cutoff_Time: 24hour time for cutoff

Pull the repo and run composer install - **PHP version 8.2**
