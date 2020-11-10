<?php

class Goal {
    private $goal_id;
    private $date;
    private $user_id;
    private $description;

    public function __construct($goal_id, $user_id, $date, $description) {
        $this->goal_id = $goal_id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->description = $description;
    }

    public function getGoalId() {
        return $this->goal_id;
    }

    public function getUser() {
        return $this->user_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getDescription() {
        return $this->description;
    }

}


?>