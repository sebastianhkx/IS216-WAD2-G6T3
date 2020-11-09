<?php

class DAYS_UNAVAILABLE {
    private $linked_id;
    private $user_id;
    private $day;
    private $start_time;
    private $end_time;
    private $unavailable_id;

    public function __construct($user_id, $day, $start_time, $end_time, $unavailable_id) {
        $this->unavailable_id = $unavailable_id;
        $this->user_id = $user_id;
        $this->day = $day;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        
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

    public function getUnavID() {
        return $this->unavailable_id;
    }



}


?>