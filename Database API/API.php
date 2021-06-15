<?php
require_once ('db.php');
$db = new db();

if (isset($_GET['time']) && isset($_GET['location'])) {
  $time = $_GET['time'];
  $location = $_GET['location'];

  $query  = "SELECT
              *
            FROM
              Weather_data
            WHERE
              plaats = '{$location}'
                AND 
              timestamp >= DATE_SUB(NOW(),INTERVAL {$time} HOUR)
            ORDER BY
              timestamp ; ";
  $result = $db->select_query($query);
  $return = array();

  while ($row = $result->fetch_assoc()) {
    $return[] = $row;
  }
  print_r(json_encode($return));
}
else {
    $query = "SELECT plaats FROM Weather_data GROUP BY plaats";
    $result = $db->select_query($query);
    $return = array();

    while ($row = $result->fetch_assoc()) {
      $return[] = $row['plaats'];
    }

    print_r(json_encode($return));
}


 ?>
