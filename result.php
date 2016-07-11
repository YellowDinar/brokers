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
$result = '<!DOCTYPE html><html><head lang="ru"><meta charset="UTF-8"><link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><title>Сравнение контактов</title></head><body><div class="container"><table class="table">';
$k = 0;
foreach($phone_numbers as $phone) {
    if ($k < 500) {
        $db->where("phone_id", $phone['id']);
        $contacts = $db->get("contact");
    //    foreach($contacts as $contact) {
    //        echo $contact["contact_id"].', '.$contact["name"];
    //    }
    //    echo '|||';
        if(count($contacts) > 1) {
            $result .= '<tr><td>' . $phone['value'] . '</td><td><table>';
            foreach ($contacts as $contact) {
                $result .= '<tr><td><a href="https://brokerskazan.amocrm.ru/contacts/detail/' . $contact["contact_id"] . '">' . $contact["name"] . '</a></td></tr>';
            }
            $result .= '</table></td></tr>';
            $k++;
        }
    }
}
$result .= '</table></div><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script></body></html>';
$file = fopen ($_SERVER['DOCUMENT_ROOT']."result.html", "r+");
if ( !$file )
{
    echo("Ошибка открытия файла");
}
else
{
    fwrite ( $file, $result);
}
fclose ($file);

