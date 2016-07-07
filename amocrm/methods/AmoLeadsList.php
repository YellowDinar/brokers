<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90@gmail.com>
 * @since 1.0
 */

class AmoLeadsList extends AmoGetMethod implements IMethod {

    /**
     * Получение имени метода для запроса к API
     * @return mixed
     */
    public function getMethodName() {
        return '/private/api/v2/json/leads/list';
    }

    /**
     * Код метода
     * @return mixed
     */
    public function run() {
        //print_r($this->url);
        $data = $this->get();
        return $data['leads'];
    }

    /**
     * Искомый элемент, по текстовому запросу
     * (Осуществляет поиск по таким полям как : почта, телефон и любым иным полям, Не осуществляет поиск по заметкам и задачам
     * @var
     */
    public $query;

    /**
     * Дополнительный фильтр поиска, по ответственному пользователю
     * @var
     */
    public $responsible_user_id;

    /**
     * Фильтр по ID статуса сделки (Как узнать список доступных ID см. здесь)
     * @var
     */
    public $status;
} 