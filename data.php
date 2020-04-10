<?php
$db_name = 'awapp_delapp';
$db_user = 'awapp_del_admin';
$db_pass = 'Zayan@1234+-';
$db_host = '109.203.114.191';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$connection_status = "Stable Connection";


// Total customers delivered
$sqlQuery = "SELECT COUNT(*) as total_delivered_count FROM tbl_delivery 
            WHERE tbl_delivery.delivery_status != 'Pending' AND delivery_date = '".date("Y-m-d")."'";
$results = $conn->query($sqlQuery);
$deliveredCustomersCount = mysqli_fetch_assoc($results);
$deliveredCustomersCount['total_delivered_count'];



// Total bottles delivered
$sqlQuery = "SELECT SUM(total_delivered) as totalBottlesDelivered FROM tbl_delivery 
            WHERE tbl_delivery.delivery_date = '" . date("Y-m-d") . "'";
$results = $conn->query($sqlQuery);
$deliveredBottlesCount = mysqli_fetch_assoc($results);
$deliveredBottlesCount['totalBottlesDelivered'];


// Total House closed
$sqlQuery = "SELECT COUNT(*) as totalHouseClosed FROM tbl_delivery 
            WHERE tbl_delivery.delivery_status = 'HC' AND delivery_date = '" . date("Y-m-d") . "'";
$results = $conn->query($sqlQuery);
$totalHC = mysqli_fetch_assoc($results);


// Total Stock Available
$sqlQuery = "SELECT COUNT(*) as totalStockAvailable FROM tbl_delivery 
            WHERE tbl_delivery.delivery_status = 'SA' AND delivery_date = '" . date("Y-m-d") . "'";
$results = $conn->query($sqlQuery);
$totalSA = mysqli_fetch_assoc($results);

// Fetch start time
$sqlQuery = "SELECT in_time FROM tbl_truck_checkout 
            WHERE route_id = 1";
$results = $conn->query($sqlQuery);
$startTime = mysqli_fetch_assoc($results);

// Fetch end time
$sqlQuery = "SELECT out_time FROM tbl_truck_checkout 
            WHERE route_id = 1";
$results = $conn->query($sqlQuery);
$endTime = mysqli_fetch_assoc($results);

// Fetch total deliveries schedulded
$sqlQuery = "SELECT COUNT(*) as totalScheduled FROM tbl_delivery WHERE delivery_date ='" . date("Y-m-d") . "'";
$results = $conn->query($sqlQuery);
$totalScheduled = mysqli_fetch_assoc($results);


// Fetch Data for each hour
$hourlyBreakdown = array();

for ($i=8; $i <= 17; $i++) {
    $sqlQuery = "SELECT COUNT(*) as customersDelivered, CAST(SUM(total_delivered) AS INTEGER) as bottlesDelivered FROM tbl_delivery WHERE HOUR(delivered_on) = $i AND delivery_date ='" . date("Y-m-d") . "'";
    $results = $conn->query($sqlQuery);
    

    while($breakdown = mysqli_fetch_assoc($results)){

        $bottlesDelivered = ($breakdown['bottlesDelivered'] == null) ? "0" : $breakdown['bottlesDelivered'];
        $chart = "[{v: [".$i.", 0, 0], f: '".$i." am'}, ".$breakdown['customersDelivered'].",". $bottlesDelivered."]".",";
        array_push($hourlyBreakdown, $chart);
    }
}

?> 