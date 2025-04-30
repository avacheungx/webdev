<?php
    // extract 'id' from incoming data
    $id = $_GET['id'];

    // is it missing? if so, send them back to the index page
    if (!isset($id)) {
        header("Location: index.php");
        exit();
    }

    // connect to our database
    $db = new SQLite3('/home/ahc9434/databases/movies.db');

    // construct a query to delete the movie
    $sql = "DELETE FROM movies WHERE id = :id";

    // prepare the SQL statement and bind the variable $id to the placeholder value :id
    $statement = $db->prepare($sql);
    $statement->bindValue(':id', $id, SQLITE3_INTEGER);

    // execute the query
    $result = $statement->execute();

    // how many rows were affected?
    $rows_affected = $db->changes();

    // we are done with the database so we should close it
    $db->close();
    unset($db);

    if ($rows_affected) {
        // generate confirmation
        header("Location: index.php?status=deleted");
        exit();
    }
    else {
        // silent redirect back to index
        header("Location: index.php");
        exit();
    }
?>