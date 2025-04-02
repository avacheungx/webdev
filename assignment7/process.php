<?php

    // grab the incoming data
    $food = $_GET['food'];
    $activity = $_GET['activity'];

    // make sure the user filled everything out
    if ($food == 'empty' || $activity == 'empty') {
        // if not, generate an error message
        header("Location: index.php?error=missingstuff");
        exit();
    }


    // if everything is OK, diagnose the character!
    $bart = 0;
    $homer = 0;
    $lisa = 0;

    if ($food == 'bart') {
        $bart++;
    }
    else if ($food == 'homer') {
        $homer++;
    }
    else if ($food == 'lisa') {
        $lisa++;
    }
    else {
        header("Location: index.php?error=invalidcharacter");
        exit();
    }


    if ($activity == 'bart') {
        $bart++;
    }
    else if ($activity == 'homer') {
        $homer++;
    }
    else if ($activity == 'lisa') {
        $lisa++;
    }
    else {
        header("Location: index.php?error=invalidcharacter");
        exit();
    }

    // absolute file path to our results file
    $filename = getcwd() . '/data/results.txt';


    if ($bart >= $homer && $bart >= $lisa) {
        // store the name of the character in our text file
        file_put_contents($filename, "bart\n", FILE_APPEND);

        header("Location: index.php?character=bart");
        exit();
    }
    else if ($homer >= $bart && $homer >= $lisa) {
        file_put_contents($filename, "homer\n", FILE_APPEND);

        header("Location: index.php?character=homer");
        exit();
    }
    else {
        file_put_contents($filename, "lisa\n", FILE_APPEND);

        header("Location: index.php?character=lisa");
        exit();
    }


?>