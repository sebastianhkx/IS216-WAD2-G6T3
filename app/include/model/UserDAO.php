
<?php

require_once 'common.php';
    
class UserDAO{

    
    // This function gets information about a User based on a given userid
    // Return value is an User Object  or null (not found);
     public function getUserDetails($username){


        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();

        // YOUR CODE GOES HERE
        $sql = "SELECT * from userbase where username = :username";
     
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username",$username, PDO::PARAM_STR);
        $status = $stmt->execute();

        $userObject = null;
        
        if($row = $stmt->fetch()){

            $userObject = new User($row['id'], 
                                    $row['username'], 
                                    $row['passwordHash'],
                                    $row['teleHandle']
                            );
        }


        return $userObject;


    }

    //Register user!!

    public function register($username, $hashed_password, $teleHandle) {

        // Step 1 - Connect to Database
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();

        // Step 2 - Prepare SQL
        $sql = "INSERT INTO userbase (username, passwordHash, teleHandle) VALUES (
                    :username, :passwordHash, :teleHandle
                )
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':passwordHash', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':teleHandle', $teleHandle, PDO::PARAM_STR);
        
        // Step 3 - Execute SQL
        $result = $stmt->execute();
        
        // Step 5 - Clear Resources
        $stmt = null;
        $pdo = null;

        // Step 6 - Return
        return $result;
    }
    
    public function getAlluser(){


        $conn = new ConnectionManager();
        $pdo = $conn->getConnection();
    
        // YOUR CODE GOES HERE
        $sql = "SELECT * from userbase";
         
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
        // STEP 4
        $user_list = [];
        while( $row = $stmt->fetch() ) {
            $user_list[] =
                new User(
                        $row['id'], 
                        $row['username'], 
                        $row['passwordHash'],
                        $row['teleHandle']
                        );
                    }

        // STEP 5
        $stmt = null;
        $conn = null;

        // STEP 6
        return $user_list;

    
    
    }
    
}



?>
