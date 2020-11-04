<?php

class EVENT {
    private $event_id;
    private $user_id;
    private $date;
    private $start_time;
    private $end_time;
    private $location;
    private $title;
    private $description;
    private $completed;

    public function __construct($event_id, $user_id, $date, $start_time, $end_time, $location, $title, $description, $completed ) {
        $this->event_id = $event_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->location = $location;
        $this->title = $title;
        $this->description = $description;
        $this->completed = $completed;
    }

    public function getEventID() {
        return $this->event_id;
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

    public function getLocation() {
        return $this->location;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCompleted() {
        return $this->completed;
    }

}


?>