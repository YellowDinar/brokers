<?php
/**
 * Created by PhpStorm.
 * User: Веб мастер
 * Date: 20.06.2016
 * Time: 11:48
 */
set_time_limit(0);
ini_set('memory_limit', '1G');
require_once 'amocrm/Amo2.php';

$amo = new Amo(null, null, null, null, null, null);
$limit = 500;
$offset = 0;
$data = array();
$sum = 0;
while($limit === 500) {
    $arr = $amo->contactsList(array(
        'limit_rows' => $limit,
        'limit_offset' => $offset
    ));
    array_push($data, $arr);
    $limit = count($arr);
    $sum += count($arr);
    $offset += 500;
}

echo $sum;