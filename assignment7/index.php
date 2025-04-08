<!DOCTYPE html>
<html>
    <head>
        <title>Simpsons Character Quiz</title>
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
            .error {
                background-color: #ee3333;
                color: white;
                padding: 10px;
                border-radius: 5px;
                margin-bottom: 20px;
                font-weight: bold;
            }
            select {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            input[type="submit"] {
                background-color: #0066cc;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }
            input[type="submit"]:hover {
                background-color: #0055aa;
            }
            .result {
                margin-top: 20px;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 5px;
                text-align: center;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                margin-right: 10px;
                padding: 10px 15px;
                background-color: #0066cc;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #0055aa;
            }
            .character-image {
                max-width: 250px;
                margin: 0 auto;
                display: block;
            }
            form {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <h1>Which Simpsons Character Are You?</h1>

        <?php            
            //check for error parameter
            $error = isset($_GET['error']) ? $_GET['error'] : null;
            if ($error) {
        ?>
        <div class="error">Please fill out all fields in the form!</div>
        <?php
            }
            
            //check if we have a result from GET parameter or cookie
            $character = isset($_GET['character']) ? $_GET['character'] : null;
            
            // no GET parameter but there is a cookie, use it
            if (!$character && isset($_COOKIE['simpsons_character'])) {
                $character = $_COOKIE['simpsons_character'];
            }
            
            //"reset" parameter, clear the cookie and character
            if (isset($_GET['reset'])) {
                setcookie("simpsons_character", "", time() - 3600, "/");
                $character = null;
            }
            
            //we have a character to display
            if ($character) {
                $filename = "";
                $character_name = "";
                
                if ($character == 'bart') {
                    $filename = 'Bart.png';
                    $character_name = "Bart Simpson";
                }
                else if ($character == 'lisa') {
                    $filename = 'Lisa.png';
                    $character_name = "Lisa Simpson";
                }
                else if ($character == 'homer') {
                    $filename = 'Homer.png';
                    $character_name = "Homer Simpson";
                }
        ?>
                <div class="result">
                    <h2>Your result: <?php echo $character_name; ?>!</h2>
                    <?php if ($filename) { ?>
                        <img src="images/<?php echo $filename; ?>" alt="<?php echo $character_name; ?>" class="character-image">
                    <?php } ?>
                    <p>Based on your answers, you're most like <?php echo $character_name; ?>!</p>
                    <a href="index.php?reset=1">Take Quiz Again</a>
                    <a href="results.php">See All Results</a>
                </div>
        <?php
            } else {
                //show the form if we don't have a character result
        ?>
        <form action="process.php" method="GET">
            <div>
                <p><strong>What's your ideal job?</strong></p>
                <select id="job" name="job">
                    <option value="empty">Select a job</option>
                    <option value="homer">Working at a bakery</option>
                    <option value="lisa">French tutor</option>
                    <option value="bart">Prank phone call specialist</option>
                </select>
            </div>

            <div>
                <p><strong>What's your favorite food?</strong></p>
                <select id="food" name="food">
                    <option value="empty">Select a food</option>
                    <option value="bart">Pizza</option>
                    <option value="homer">Donuts</option>
                    <option value="lisa">Apples</option>
                </select>
            </div>

            <div>
                <p><strong>What's your favorite hobby?</strong></p>
                <select id="activity" name="activity">
                    <option value="empty">Select a hobby</option>
                    <option value="bart">Skateboard</option>
                    <option value="homer">Sleep</option>
                    <option value="lisa">Study</option>
                </select>
            </div>

            <div>
                <p><strong>What's your greatest fear?</strong></p>
                <select id="fear" name="fear">
                    <option value="empty">Select a fear</option>
                    <option value="bart">Flying</option>
                    <option value="homer">Math problems</option>
                    <option value="lisa">Getting anything below an A in school</option>
                </select>
            </div>
            <br>
            <input type="submit" value="Which Simpsons Character am I?">
        </form>
        <br>
        <a href="results.php">See Aggregate Results</a>
        <?php
            }
        ?>
    </body>
</html>