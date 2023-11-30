<?php
function add_admin($user, $password) {
    global $db;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO Users (UserName, password_hash)
              VALUES (:user, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user', $user);
    $statement->bindValue(':password', $hash);
    $statement->execute();
    $statement->closeCursor();
}

function is_valid_admin_login($user, $password) {
    global $db;


    /* to sneak in with any user/password 
    user - password 
    add_admin($user,$password); */



    /* $hash = password_hash($password, PASSWORD_DEFAULT);
    echo $hash; */

    $query = 'SELECT password_hash FROM users
              WHERE UserName = :user';
    $statement = $db->prepare($query);
    $statement->bindValue(':user', $user);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if($row === False)
    {
        return False;
    }
    
    $hash = $row['password_hash'];
    return password_verify($password, $hash);   
}

function is_valid_user_login($username, $password) {
    global $db;

    $query = "SELECT * FROM users WHERE UserName = :username";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    // $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    // echo $username;
    // echo $password;

    $row = $stmt->fetch();
    $hash = $row['password_hash'];
    $_SESSION['user'] = $row;
        
    return password_verify($password, $hash);
}
?>