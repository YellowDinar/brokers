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
$rrr = 0;
foreach($data as $part) {
    foreach($part as $contact) {
        foreach($contact['custom_fields'] as $field) {
            if (strcmp($field['id'], '803138') === 0) {
                foreach($field['values'] as $value) {
                    preg_match('/\d+/', $value['value'], $r);
                    $number = $r[0];
                    if (strlen($number) > 6) {
                        if (strlen($number) > 7) {
                            echo substr($number, -10).', ';
                            $rrr += 1;
                        } else {
                            echo $number.', ';
                            $rrr += 1;
                        }
                    }
                }
                echo '||||||||||';
            }
        }
    }
}


echo '====== '.$rrr.' =======';

//$db = new MysqliDb ('localhost', 'kostiasplin_amo', '88005003360', 'kostiasplin_amo');
//$insert_data = Array (
//    "contact_id" => $contacts[0]['id'],
//    "timestamp" => date(time())
//);
//$db->insert ('contact', $insert_data);