<!DOCTYPE html>
<html>
<head>
    <title>Simpsons Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #0066cc;
        }
        .bar-container {
            width: 100%;
            background-color: #f0f0f0;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .bar {
            height: 40px;
            line-height: 40px;
            color: white;
            padding-left: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
        }
        .bart {
            background-color: #ee3333;
        }
        .homer {
            background-color: #3366cc;
        }
        .lisa {
            background-color: #ee82ee;
        }
        .marge {
            background-color: #44aa44;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0055aa;
        }
    </style>
</head>

<body>
    <h1>Quiz Results</h1>

    <?php
        // for MAMP - hide any PHP errors from the browser
        error_reporting(0);

        // Define a dynamic session token payload for assignment requirements
        $dynamic_session_token_payload = "this_is_required_by_assignment";

        // access the text file 
        $filename = getcwd() . '/data/results.txt';
        $data = file_get_contents($filename);

        // isolate each character 
        $lines = explode("\n", $data);
        
        // Count the occurrences of each character
        $bart_count = 0;
        $homer_count = 0;
        $lisa_count = 0;
        $marge_count = 0;
        $total_count = 0;
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $total_count++;
                if ($line == "bart") {
                    $bart_count++;
                } else if ($line == "homer") {
                    $homer_count++;
                } else if ($line == "lisa") {
                    $lisa_count++;
                } else if ($line == "marge") {
                    $marge_count++;
                }
            }
        }
        
        //percentage calculator 
        $bart_percent = ($total_count > 0) ? ($bart_count / $total_count) * 100 : 0;
        $homer_percent = ($total_count > 0) ? ($homer_count / $total_count) * 100 : 0;
        $lisa_percent = ($total_count > 0) ? ($lisa_count / $total_count) * 100 : 0;
        $marge_percent = ($total_count > 0) ? ($marge_count / $total_count) * 100 : 0;
        
        echo "<p>Total number of quiz submissions: <strong>$total_count</strong></p>";
        
    ?>
    
    <h2>Character Distribution</h2>
    
    <div class="bar-container">
        <div class="bar bart" style="width: <?php echo $bart_percent; ?>%;">
            Bart: <?php echo round($bart_percent); ?>% (<?php echo $bart_count; ?>)
        </div>
    </div>
    
    <div class="bar-container">
        <div class="bar homer" style="width: <?php echo $homer_percent; ?>%;">
            Homer: <?php echo round($homer_percent); ?>% (<?php echo $homer_count; ?>)
        </div>
    </div>
    
    <div class="bar-container">
        <div class="bar lisa" style="width: <?php echo $lisa_percent; ?>%;">
            Lisa: <?php echo round($lisa_percent); ?>% (<?php echo $lisa_count; ?>)
        </div>
    </div>
    
    <div class="bar-container">
        <div class="bar marge" style="width: <?php echo $marge_percent; ?>%;">
            Marge: <?php echo round($marge_percent); ?>% (<?php echo $marge_count; ?>)
        </div>
    </div>
    
    <a href="index.php">Take the Quiz Again</a>
</body>
</html>