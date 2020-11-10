<?php

//if ( !isset($_SESSION['userid'])) {
//    header("Location: login.html"); 
//    exit();
//}

require_once 'common.php';

//call add function!!

if ($_POST['type'] == "add") {
    $date = $_POST['date'];
    $description = $_POST['goal'];
    $user_id = $_SESSION['userid'];
    $dao = new GoalDao();
    $status = $dao->insert_goal_day($user_id, $date, $description);

    if ($status) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }

} else if ($_POST['type'] == "read") {
    
    $date = $_POST['date'];
    $user_id = $_SESSION['userid'];

    $dao = new GoalDao();
    $goaldata = $dao->get_goal_of_day($user_id, $date);

    $goals = [];
    foreach ($goaldata as $goal_object) {
        $goal = [];
        $goal["goal_id"] = $goal_object->getGoalId();
        $goal["user_id"] = $goal_object->getUser();
        $goal["date"] = $goal_object->getDate();
        $goal["description"] = $goal_object->getDescription();
        $goals[] = $goal;
    }

    // make posts into json and return json data
    $postJSON = json_encode($goals);
    echo $postJSON;

} else if ($_POST['type'] == "edit") {

    $goal_id = $_POST['goal_id'];
    $date = $_POST['date'];
    $description = $_POST['goal'];
    $user_id = $_SESSION['userid'];

    //Edit
    $dao = new GoalDao();
    $goalResult = $dao->edit_goal_data($goal_id, $user_id ,$date, $description);

    if ($goalResult) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }

} else if ($_POST['type'] == "delete") {

    $user_id = $_SESSION['userid'];
    $goal_id = $_POST['goal_id'];

    $dao = new GoalDao();
    $goalResult = $dao->delete_goal($goal_id, $user_id);

    if ($goalResult) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201));
    }

}






// }
