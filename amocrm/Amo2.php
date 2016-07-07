<?php

/**
 * Created by PhpStorm.
 * User: Веб мастер
 * Date: 20.06.2016
 * Time: 11:50
 */

require_once 'AmoCrm.php';


class Amo
{
    var $email = 'aaccent@brokers-kazan.ru';
    var $apiKey = '899f3ff0994a551e6afd853ea3742810';
    var $subDomain = 'brokerskazan';
    var $name;
    var $phone;
    var $uemail;
    var $message;
    //var $responsible_user = 186706; Kuzovenin
    var $responsible_user = 806578;
    var $amo;
    var $lead_id;
    var $contact_id;
    var $user_group_id = 0;
    var $tag;
    var $visit;

    function __construct($name = null, $phone = null, $uemail = null, $message = null, $tag = null, $visit = null)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->uemail = $uemail;
        $this->message = $message;
        $this->amo = new AmoCrm($this->email, $this->apiKey, $this->subDomain);
        $this->tag = $tag;
        $this->visit = $visit;
    }

    function contactsList($arr) {
        return $this->amo->ContactsList(
            $arr
        );
    }

    function contactsLinks($arr)
    {
        return $this->amo->ContactsLinks(
            array('contacts_link' => $arr)
        );
    }

    function setData($lead_id, $contact_id)
    {
        $this->lead_id = $lead_id;
        $this->contact_id = $contact_id;
    }

    function addNotes($notes)
    {
        $task = $this->amo->NotesSet(array('add' => $notes));
        return $task['notes']['add'][0];
    }

    function addTasks($tasks)
    {
        $task = $this->amo->TasksSet(array('add' => $tasks));
        return $task['tasks']['add'][0];
    }

    function addLeads($leads)
    {
        $lead = $this->amo->LeadsSet(array('add' => $leads));
        return $lead['leads']['add'][0];
    }

    function updateLeads($leads)
    {
        $lead = $this->amo->LeadsSet(array('update' => $leads));
        return $lead['leads']['update'][0];
    }

    function addContacts($contacts)
    {
        $contact = $this->amo->ContactsSet(array('add' => $contacts));
        return $contact['contacts']['add'][0];
    }

    function updateContacts($contacts)
    {
        $contact = $this->amo->ContactsSet(array('update' => $contacts));
        return $contact['contacts']['add'][0];
    }

    function run()
    {
        if (strlen($this->phone) > 7) {
            $check_phone = substr($this->phone, -10);
        } else {
            $check_phone = $this->phone;
        }
        $contacts = $this->amo->ContactsList(array('query' => $check_phone));
        if (count($contacts) > 0 && $this->phone != null) {
            $tags = array();
            foreach($contacts[0]['tags'] as $tag) {
                array_push($tags, $tag['name']);
            }
            array_push($tags, $this->tag.':'.date("m.Y"));

            $contact_data['id'] = $contacts[0]['id'];
            $contact_data['tags'] = implode(",", $tags);
            $contact_data['last_modified'] = time();
            if ($this->visit != null) {
                $visit_data =  array(
                    'id'=>1286106,
                    'values'=>array(
                        array(
                            'value'=>$this->visit
                        )
                    )
                );
            }
            if (!empty($visit_data) && $this->visit != null) {
                $contact_data['custom_fields']  = array();
                array_push($contact_data['custom_fields'], $visit_data);
            }
            $contact = $this->updateContacts(
                array($contact_data)
            );
            if($this->visit != null) {
                $db = new MysqliDb ('localhost', 'kostiasplin_amo', '88005003360', 'kostiasplin_amo');
                $insert_data = Array (
                    "contact_id" => $contacts[0]['id'],
                    "timestamp" => date(time())
                );
                $db->insert ('contact', $insert_data);
            }
            $notes = array(
                'element_id' => $contacts[0]['id'],
                'element_type' => 1,
                'note_type' => 4,
                'text' => $this->tag.':'.date("m.Y"),
                'responsible_user_id' => $this->responsible_user
            );
            $note = $this->addNotes(
                array($notes)
            );

            $task_message = 'Перезвонить клиенту';
            if (strlen($this->phone) > 0)
                $task_message .= ' по номеру '.$this->phone;
            $task_message .= ' в самое ближайшее время';
            $tasks = array(
                'element_id' => $contacts[0]['id'],
                'element_type' => 1,
                'task_type' => 1,
                'text' => $task_message,
                'responsible_user_id' => $this->responsible_user,
                'complete_till' => date(time()) + 600
            );
            $task = $this->addTasks(
                array($tasks)
            );
        } else {
            $data = array('responsible_user_id' => $this->responsible_user);

            $data['tags'] = $this->tag.':'.date("m.Y");

            if (strlen($this->name) > 0)
                $data['name'] = $this->name;
            else
                $data['name'] = 'Новый контакт';

            $data['custom_fields']  = array();
            if (strlen($this->phone) > 0 && $this->phone != null) {
                $phone_data = array(
                    'id' => 803138,
                    'values' => array(
                        array(
                            'value' => $this->phone,
                            'enum' => 'WORK'
                        ),
                    )
                );
            }
            if (strlen($this->uemail) > 0 && $this->uemail != null) {
                $uemail_data =  array(
                    'id'=>803140,
                    'values'=>array(
                        array(
                            'value'=>$this->uemail,
                            'enum'=>'WORK'
                        )
                    )
                );
            }

            if ($this->visit != null) {
                $visit_data =  array(
                    'id'=>1286106,
                    'values'=>array(
                        array(
                            'value'=>$this->visit
                        )
                    )
                );
            }

            if (!empty($phone_data) && $this->phone != null)
                array_push($data['custom_fields'], $phone_data);
            if (!empty($uemail_data) && $this->uemail != null)
                array_push($data['custom_fields'], $uemail_data);
            if (!empty($visit_data) && $this->visit != null)
                array_push($data['custom_fields'], $visit_data);

            $contact = $this->addContacts(
                array($data)
            );

            if($this->visit != null) {
                $db = new MysqliDb ('localhost', 'kostiasplin_amo', '88005003360', 'kostiasplin_amo');
                $insert_data = Array (
                    "contact_id" => $contact['id'],
                    "timestamp" => date(time())
                );
                $db->insert ('contact', $insert_data);
            }

            $notes = array(
                'element_id' => $contact['id'],
                'element_type' => 1,
                'note_type' => 4,
                'text' => $this->tag.':'.date("m.Y").' - roistat-visit : '.$this->visit,
                'responsible_user_id' => $this->responsible_user
            );
            $note = $this->addNotes(
                array($notes)
            );

            if($this->message != null) {
                $notes = array(
                    'element_id' => $contact['id'],
                    'element_type' => 1,
                    'note_type' => 4,
                    'text' => $this->message,
                    'responsible_user_id' => $this->responsible_user
                );
                $note = $this->addNotes(
                    array($notes)
                );
            }

            $task_message = 'Перезвонить клиенту';
            if (strlen($this->phone) > 0)
                $task_message .= ' по номеру '.$this->phone;
            $task_message .= ' в самое ближайшее время';
            $tasks = array(
                'element_id' => $contact['id'],
                'element_type' => 1,
                'task_type' => 1,
                'text' => $task_message,
                'responsible_user_id' => $this->responsible_user,
                'complete_till' => date(time()) + 600
            );
            $task = $this->addTasks(
                array($tasks)
            );

        }
    }

    function run_parser()
    {
        if($this->phone != null) {
            $this->run();
        } else {
            $data = array('responsible_user_id' => $this->responsible_user);

            $data['tags'] = $this->tag.':'.date("m.Y");

            $data['name'] = 'Контакт ('.$this->tag.')';

            $contact = $this->addContacts(
                array($data)
            );

            if($this->message != null) {
                $notes = array(
                    'element_id' => $contact['id'],
                    'element_type' => 1,
                    'note_type' => 4,
                    'text' => $this->message,
                    'responsible_user_id' => $this->responsible_user
                );
                $note = $this->addNotes(
                    array($notes)
                );
            }

            $task_message = 'Перезвонить клиенту в самое ближайшее время';
            $tasks = array(
                'element_id' => $contact['id'],
                'element_type' => 1,
                'task_type' => 1,
                'text' => $task_message,
                'responsible_user_id' => $this->responsible_user,
                'complete_till' => date(time()) + 600
            );
            $task = $this->addTasks(
                array($tasks)
            );
        }
    }
}
