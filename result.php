<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 11.07.16
 * Time: 2:18
 */

set_time_limit(0);
ini_set('memory_limit', '1G');
require_once 'amocrm/MysqliDb.php';

$db = new MysqliDb ('localhost', 'root', 'root', 'brokers');

$phone_numbers = $db->get('phone');
$result = array();
foreach($phone_numbers as $phone) {
    $db->where ("phone_id", $phone['id']);
    $contacts = $db->get("contact");
    echo print_r($contacts).'|||||||||||||';
}