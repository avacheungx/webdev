<?php

    if (!isset($_GET['command'])) {
        print "error";
        exit();
    }

    // connect to our database
    $path = __DIR__ . '/databases'; //pathing sucks
    $db = new SQLite3($path.'/chat.db');

    //create the user tbale if it doesnt exist (IT SHOULDDDDD ALREADY BUT YK)
    $db->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT,
        password TEXT
    )');

    // API call to save a message to the 'messages' table
    // requirements:
    //                  command = "savemessage"
    //                  $_POST['username'] (string)
    //                  $_POST['message'] (string)
    if ($_GET['command'] == 'savemessage' && isset($_POST['username']) && isset($_POST['message'])) {

        // construct a SQL statement to save this message to our database
        $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':message', $_POST['message']);
        $result = $statement->execute();
        $id = $db->lastInsertRowID();

        // make sure the record was saved successfully and report back to the client
        if ($id) {
            print "success";
        }
        else {
            print "error";
        }
    }

    // API call to retrieve all messages from the 'messages' table after a given id
    // requirements:
    //                  command = "getmessages"
    //                  $_POST['id'] (integer)
    else if ($_GET['command'] == 'getmessages' && isset($_POST['id'])) {

        // construct a SQL statement to retrieve all messages greater than the supplied id
        $sql = "SELECT id, username, message, date FROM messages WHERE id > :id ORDER BY id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $_POST['id']);
        $result = $statement->execute();

        // construct an object to send back to the client
        // this object will have two properties:
        // - messages: an array of messages, ordered by id
        // - id: an integer representing the last id included in the messages array
        $send_back = [];
        $send_back['messages'] = [];
        $send_back['id'] = $_POST['id'];

        // iterate over the result set
        while ($row = $result->fetchArray()) {
            
            // store the result in an object
            $record = [];
            $record['id'] = $row[0];
            $record['username'] = $row[1];
            $record['message'] = $row[2];
            $record['date'] = $row[3];

            // push the object onto the 'messages' array
            array_push($send_back['messages'], $record);

            // update the 'id' variable to keep track of the largest id
            $send_back['id'] = $record['id'];
        }

        // encode the object as a JSON string and send it to the client
        print json_encode($send_back);
    }
    // API call to authenticate a user or create a new account
    // requirements:
    //                  command = "authenticate"
    //                  $_POST['username'] (string)
    //                  $_POST['password'] (string)
    else if ($_GET['command'] == 'authenticate' && isset($_POST['username']) && isset($_POST['password'])) {
        //check is user exists
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $result = $statement->execute();
        $count = $result->fetchArray()[0];
    
        //user exists -> verify password
        if ($count > 0) {
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', $_POST['username']);
            $statement->bindValue(':password', $_POST['password']);
            $result = $statement->execute();
            $match = $result->fetchArray()[0];
    
            if ($match > 0) {
                //password matches
                print "success";
            } else {
                //no matchy
                print "incorrect";
            }
        } 
        //user dont exist -> create accouunt
        else {
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', $_POST['username']);
            $statement->bindValue(':password', $_POST['password']);
            $result = $statement->execute();
            $id = $db->lastInsertRowID();
    
            if ($id) {
                print "success";
            } else {
                print "error";
            }
        }
    }

    // close the database and release it for the next request
    $db->close();
    unset($db);

?>