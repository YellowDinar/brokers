<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10.07.16
 * Time: 20:11
 */
set_time_limit(0);
ini_set('memory_limit', '1G');
require_once 'amocrm/Amo2.php';
require_once 'amocrm/MysqliDb.php';

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
$db = new MysqliDb ('localhost', 'root', 'root', 'brokers');
foreach($data as $part) {
    foreach($part as $contact) {
        foreach($contact['custom_fields'] as $field) {
            if (strcmp($field['id'], '803138') === 0) {
                foreach($field['values'] as $value) {
                    preg_match('/\d+/', $value['value'], $r);
                    if (isset($r[0])){
                        $number = $r[0];
                        if (strlen($number) > 6) {
                            if (strlen($number) > 7) {
                                $db->where ("value", substr($number, -10));
                                $phone = $db->getOne ("phone");
                                echo print_r($phone).' , ';
                            } else {
                                $db->where ("value", $number);
                                $phone = $db->getOne ("phone");
                                echo print_r($phone).' , ';
                            }
                            echo '||||||||||||||';
                        }
                    }
                }
            }
        }
    }
}