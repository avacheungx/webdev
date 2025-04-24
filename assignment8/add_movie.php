<?php
    // extract title and year from incoming POST data
    $title = $_POST['title'];
    $year = $_POST['year'];

    // check if any required fields are missing
    if (!isset($title) || $title === '' || !isset($year) || $year === '') {
        // redirect back to the form with an error message
        header("Location: add_form.php?status=error");
        exit();
    }

    // validate that year is a number
    if (!is_numeric($year)) {
        header("Location: add_form.php?status=invalid_year");
        exit();
    }

    // connect to our database
    $db = new SQLite3('databases/movies.db');

    // construct a query to insert the new movie
    $sql = "INSERT INTO movies (title, year) VALUES (:title, :year)";

    // prepare the SQL statement and bind the variables to the placeholder values
    $statement = $db->prepare($sql);
    $statement->bindValue(':title', $title, SQLITE3_TEXT);
    $statement->bindValue(':year', $year, SQLITE3_INTEGER);

    // execute the query
    $result = $statement->execute();

    // how many rows were affected?
    $rows_affected = $db->changes();

    // we are done with the database so we should close it
    $db->close();
    unset($db);

    if ($rows_affected) {
        // generate confirmation and redirect to index
        header("Location: index.php?status=added");
        exit();
    }
    else {
        // something went wrong, redirect back to the form
        header("Location: add_form.php?status=failed");
        exit();
    }
?>