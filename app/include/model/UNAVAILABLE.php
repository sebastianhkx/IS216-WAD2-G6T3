<?php

class UNAVAILABLE {
    private $unavailable_id;
    private $user_id;
    private $date;
    private $start_time;
    private $end_time;
    private $repeatable;
    private $title;
    private $description;

    public function __construct($unavailable_id, $user_id, $date, $start_time, $end_time, $repeatable, $title, $description) {
        $this->unavailable_id = $unavailable_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->repeatable = $repeatable;
        $this->title = $title;
        $this->description = $description;
    }

    public function getUnavailableID() {
        return $this->unavailable_id;
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

    public function getRepeatable() {
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