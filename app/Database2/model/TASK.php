<?php

class TASK {
    private $task_id;
    private $user_id;
    private $date;
    private $start_time;
    private $end_time;
    private $repeatable;
    private $title;
    private $description;

    public function __construct($task_id, $user_id, $date, $start_time, $end_time, $repeatable, $title, $description) {
        $this->task_id = $task_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->repeatable = $repeatable;
        $this->title = $title;
        $this->description = $description;
    }

    public function getTaskID() {
        return $this->task_id;
    }

    public function getUser() {
        return $this->user_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getStartTime() {
        return $this->start_time;
    }

    public function getEndTime() {
        return $this->end_time;
    }

    public function getRepeatableeeeeeeeeeee() {
        return $this->repeatable;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

}


?>