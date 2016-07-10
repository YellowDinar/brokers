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
$result = '<!DOCTYPE html><html><head lang="ru"><meta charset="UTF-8"><title>Сравнение контактов</title></head><body><table>';
foreach($phone_numbers as $phone) {
    $db->where ("phone_id", $phone['id']);
    $contacts = $db->get("contact");
    $result .= '<tr><td>'.$phone["value"].'</td><td><table>';
    foreach($contacts as $contact) {
        $result .= '<tr><td><a href="https://brokerskazan.amocrm.ru/contacts/detail/'.$contact["contact_id"].'">'.$contact["name"].'</a></td></tr>';
    }
    $result .= '</table></td></tr>';
}
$result = '</table></body></html>';

$file = fopen ("test.html","r+");
if ( !$file )
{
    echo("Ошибка открытия файла");
}
else
{
    fputs ( $file, $result);
}
fclose ($file);