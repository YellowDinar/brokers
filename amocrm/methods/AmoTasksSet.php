<?php

class AmoTasksSet extends AmoPostMethod implements IMethod {

    /**
     * Получение имени метода для запроса к API
     * @return mixed
     */
    public function getMethodName() {
        return '/private/api/v2/json/tasks/set';
    }

    public function run() {
        $request = array(
            'request' => array(
                'tasks' => array(
                    'add' => $this->add
                )
            )
        );
        return $this->post($request);
    }

    /**
     * Array of creating leads
     * @var
     */
    public $add;

}
