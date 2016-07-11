<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 11.07.16
 * Time: 2:18
 */



ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

ini_set('memory_limit', '1500M');
require_once 'amocrm/MysqliDb.php';

$db = new MysqliDb ('localhost', 'root', 'root', 'brokers');

$phone_numbers = $db->get('phone');
$result = '<!DOCTYPE html><html><head lang="ru"><meta charset="UTF-8"><title>Сравнение контактов</title></head><body><table>';
$k = 0;
foreach($phone_numbers as $phone) {
    while($k < 50) {
        $db->where("phone_id", $phone['id']);
        $contacts = $db->get("contact");
//    foreach($contacts as $contact) {
//        echo $contact["contact_id"].', '.$contact["name"];
//    }
//    echo '|||';
        $result .= '<tr>';
        foreach ($contacts as $contact) {
            $result .= '<td><a href="https://brokerskazan.amocrm.ru/contacts/detail/' . $contact["contact_id"] . '">' . $contact["name"] . '</a></td>';
        }
        $result .= '</tr>';
        $k++;
    }
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