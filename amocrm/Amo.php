<?php
///**
// * Created by PhpStorm.
// * User: mac
// * Date: 07.03.16
// * Time: 17:53
// */
////include '/Users/mac/Documents/Apache/amocrm/AmoCrm.php';
//require_once 'AmoCrm.php';
//
//
//class Amo
//{
//
//    var $email = 'aaccent@brokers-kazan.ru';
//    var $apiKey = '899f3ff0994a551e6afd853ea3742810';
//    var $subDomain = 'brokerskazan';
//    var $name;
//    var $phone;
//    var $uemail;
//    var $message;
//    var $responsible_user = 186706;
//    var $amo;
//    var $lead_id;
//    var $contact_id;
//    var $user_group_id = 0;
//
//    function __construct($name = null, $phone = null, $uemail = null, $message = null)
//    {
//        $this->name = $name;
//        $this->phone = $phone;
//        $this->uemail = $uemail;
//        $this->message = $message;
//        $this->amo = new AmoCrm($this->email, $this->apiKey, $this->subDomain);
//    }
//
//    function setData($lead_id, $contact_id)
//    {
//        $this->lead_id = $lead_id;
//        $this->contact_id = $contact_id;
//    }
//
//    function addTasks($tasks)
//    {
//        $task = $this->amo->TasksSet(array('add' => $tasks));
//        return $task['tasks']['add'][0];
//    }
//
//    function addLeads($leads)
//    {
//        $lead = $this->amo->LeadsSet(array('add' => $leads));
//        return $lead['leads']['add'][0];
//    }
//
//    function addContacts($contacts)
//    {
//        $contact = $this->amo->ContactsSet(array('add' => $contacts));
//        return $contact['contacts']['add'][0];
//    }
//
//    function updateContacts($contacts)
//    {
//        $contact = $this->amo->ContactsSet(array('update' => $contacts));
//        return $contact['contacts']['add'][0];
//    }
//
//    function run()
//    {
//        $contacts = $this->amo->ContactsList(array('query' => $this->phone));
//        if (count($contacts) > 0 && $this->phone != null) {
//            $data = array('responsible_user_id' => $this->responsible_user);
//            if (strlen($this->name) > 0)
//                $data['name'] = $this->name;
//            else
//                $data['name'] = 'Новая сделка';
//            $data['status_id'] = 10909243;
//            $lead = $this->addLeads(
//                array($data)
//            );
//
//            if (isset($lead['id'])) {
//                $contact_data['id'] = $contacts[0]['id'];
//                $contact_data['linked_leads_id'] = array($lead['id']);
//                $contact_data['responsible_user_id'] = $this->responsible_user;
//                $contact_data['last_modified'] = time();
//                $contact = $this->updateContacts(
//                    array($contact_data)
//                );
//                $task_message = 'Перезвонить клиенту';
//                if (strlen($this->phone) > 0)
//                    $task_message .= ' по номеру '.$this->phone;
//                $task_message .= ' в самое ближайшее время';
//                $tasks = array(
//                    'element_id' => $lead['id'],
//                    'element_type' => 2,
//                    'task_type' => 1,
//                    'text' => $task_message,
//                    'responsible_user_id' => $this->responsible_user,
//                    'complete_till' => date(time()) + 3600
//                );
//                $task = $this->addTasks(
//                    array($tasks)
//                );
//            }
//
//        } else {
//            $data = array('responsible_user_id' => $this->responsible_user);
//            if (strlen($this->name) > 0)
//                $data['name'] = $this->name;
//            else
//                $data['name'] = 'Новая сделка';
//            $data['status_id'] = 10909243;
//            $lead = $this->addLeads(
//                array($data)
//            );
//            if (strlen($this->name) > 0)
//                $data['name'] = $this->name;
//            else
//                $data['name'] = 'Новый контакт';
//            $data['custom_fields']  = array();
//            if (strlen($this->phone) > 0 && $this->phone != null) {
//                $phone_data = array(
//                        'id' => 803138,
//                        'values' => array(
//                            array(
//                                'value' => $this->phone,
//                                'enum' => 'WORK'
//                            ),
//                        )
//                );
//            }
//            if (strlen($this->uemail) > 0 && $this->uemail != null) {
//                $uemail_data =  array(
//                    'id'=>803140,
//                    'values'=>array(
//                        array(
//                            'value'=>$this->uemail,
//                            'enum'=>'WORK'
//                        )
//                    )
//                );
//            }
//            if (strlen($this->message) > 0) {
//                $message_data =  array(
//                    'id' => 1285791,
//                    'values' => array(
//                        array(
//                            'value' => $this->message
//                        )
//                    )
//                );
//            }
//            if (!empty($phone_data) && $this->phone != null)
//                array_push($data['custom_fields'], $phone_data);
//            if (!empty($uemail_data) && $this->uemail != null)
//                array_push($data['custom_fields'], $uemail_data);
//            if ($message_data)
//                array_push($data['custom_fields'], $message_data);
//            if (isset($lead['id'])) {
//                $data['linked_leads_id'] = array($lead['id']);
//            }
//            $contact = $this->addContacts(
//                array($data)
//            );
//            $task_message = 'Перезвонить клиенту';
//            if (strlen($this->phone) > 0)
//                $task_message .= ' по номеру '.$this->phone;
//            $task_message .= ' в самое ближайшее время';
//            $tasks = array(
//                'element_id' => $lead['id'],
//                'element_type' => 2,
//                'task_type' => 1,
//                'text' => $task_message,
//                'responsible_user_id' => $this->responsible_user,
//                'complete_till' => date(time()) + 3600
//            );
//            $task = $this->addTasks(
//                array($tasks)
//            );
//
//        }
//    }
//
//}
//
//?>