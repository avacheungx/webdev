<?php
    // grab all the incoming data
    $job = $_GET['job'];
    $food = $_GET['food'];
    $activity = $_GET['activity'];
    $fear = $_GET['fear'];

    // make sure the user filled everything out
    if ($job == 'empty' || $food == 'empty' || $activity == 'empty' || $fear == 'empty') {
        // if not, generate an error message
        header("Location: index.php?error=1");
        exit();
    }

    $bart = 0;
    $homer = 0;
    $lisa = 0;

    //job selection
    if ($job == 'bart') {
        $bart++;
    }
    else if ($job == 'homer') {
        $homer++;
    }
    else if ($job == 'lisa') {
        $lisa++;
    }
    else {
        header("Location: index.php?error=invalidcharacter");
        exit();
    }

    //food selection
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

    //activity selection
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

    //fear selection
    if ($fear == 'bart') {
        $bart++;
    }
    else if ($fear == 'homer') {
        $homer++;
    }
    else if ($fear == 'lisa') {
        $lisa++;
    }
    else {
        header("Location: index.php?error=invalidcharacter");
        exit();
    }

    //make sure file exists
    $dataDir = getcwd() . '/data';
    if (!file_exists($dataDir)) {
        mkdir($dataDir, 0777, true);
    }
    
    // absolute file path to our results file
    $filename = $dataDir . '/results.txt';

    // Determine which character got the most points
    $character = "";
    if ($bart >= $homer && $bart >= $lisa) {
        // store the name of the character in our text file
        $character = "bart";
    }
    else if ($homer >= $bart && $homer >= $lisa) {
        $character = "homer";
    }
    else {
        $character = "lisa";
    }
    
    //save the result to the file
    file_put_contents($filename, "$character\n", FILE_APPEND);
    
    //set a cookie to remember the result
    setcookie("simpsons_character", $character, time() + 86400 * 30, "/"); 
    
    //redirect to show the result
    header("Location: index.php?character=$character");
    exit();
?>