<?php

class DAYS_TASK {
    private $linked_id;
    private $user_id;
    private $day;
    private $start_time;
    private $end_time;
    private $task_id;

    public function __construct($linked_id, $user_id, $day, $start_time, $end_time, $task_id) {
        $this->linked_id = $linked_id;
        $this->user_id = $user_id;
        $this->day = $day;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->task_id = $task_id;
    }

    public function getLinkedID() {
        return $this->linked_id;
    }

    public function getUser() {
        return $this->user_id;
    }

    public function getDay() {
        return $this->day;
    }

    public function getStartTime() {
        return $this->start_time;
    }

    public function getEndTime() {
        return $this->end_time;
    }

    public function getTaskID() {
        return $this->task_id;
    }



}


?>