<?php

function json_validator_response($validator){

    if ($validator->fails()) {
        $errors = "";
        foreach ($validator->messages()->all() as $error){
            $errors .= $error."<br>";
        }
        return  Response::json(array("status" => "failed", "message" => $errors));
    }

}


function getDatesFromRange($start, $end, $format = 'Y-m-d',$Inter='P1D') {

    // Declare an empty array
    $array = array();

    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval($Inter);

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    // Use loop to store date into array
    foreach($period as $date) {

        $array[] = $date->format('d-m-Y - l');
    }

    // Return the array elements
    return $array;
}


?>