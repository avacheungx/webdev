<?php
    
    // grab all the incoming data
    $job = $_GET['job'];
    $food = $_GET['food'];
    $activity = $_GET['activity'];
    $fear = $_GET['fear'];
    $stress = $_GET['stress']; 

    // make sure the user filled everything out
    if ($job == 'empty' || $food == 'empty' || $activity == 'empty' || $fear == 'empty' || $stress == 'empty') {
        // if not, generate an error message
        header("Location: index.php?error=1");
        exit();
    }

    $bart = 0;
    $homer = 0;
    $lisa = 0;
    $marge = 0; 

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
    else if ($job == 'marge') {
        $marge++;
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
    else if ($food == 'marge') {
        $marge++;
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
    else if ($activity == 'marge') {
        $marge++;
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
    else if ($fear == 'marge') {
        $marge++;
    }
    else {
        header("Location: index.php?error=invalidcharacter");
        exit();
    }
    
    //stress response selection
    if ($stress == 'bart') {
        $bart++;
    }
    else if ($stress == 'homer') {
        $homer++;
    }
    else if ($stress == 'lisa') {
        $lisa++;
    }
    else if ($stress == 'marge') {
        $marge++;
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
    
    //find the maximum score
    $max_score = max($bart, $homer, $lisa, $marge);
    
    //determine which character has the maximum score
    if ($bart == $max_score) {
        $character = "bart";
    }
    else if ($homer == $max_score) {
        $character = "homer";
    }
    else if ($lisa == $max_score) {
        $character = "lisa";
    }
    else if ($marge == $max_score) {
        $character = "marge";
    }
    
    //save the result to the file
    file_put_contents($filename, "$character\n", FILE_APPEND);
    
    //set a cookie to remember the result
    setcookie("simpsons_character", $character, time() + 86400 * 30, "/"); 
    
    //redirect to show the result
    header("Location: index.php?character=$character");
    exit();
?>