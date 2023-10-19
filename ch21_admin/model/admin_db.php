<?php
function add_admin($email, $password) {
    global $db;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = 'INSERT INTO administrators (emailAddress, password)
              VALUES (:email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $hash);
    $statement->execute();
    $statement->closeCursor();
}

function is_valid_admin_login($email, $password) {
    global $db;

    /* $hash = password_hash($password, PASSWORD_DEFAULT);
    echo $hash; */

    $query = 'SELECT password FROM administrators
              WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if($row === False)
    {
        return False;
    }
    
    $hash = $row['password'];
    return password_verify($password, $hash);
}
?>