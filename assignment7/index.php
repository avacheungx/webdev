<!DOCTYPE html>
<html>
    <head>
        <title>Assignment 07</title>
        <style>
            .error {
                background-color: red;
                color: white;
                padding: 10px;
                width: 100%;
                height: 50px;
            }
        </style>
    </head>
    <body>
        <h1>Assignment 07</h1>

        <?php

            $error = $_GET['error'];
            if ($error) {

        ?>

        <div class="error">Fill out the form!</div>

        <?php
            }
        ?>

        <?php

            $character = $_GET['character'];
            $filename = "";

            if ($character == 'bart') {
                $filename = 'Bart.png';
            }
            else if ($character == 'lisa') {
                $filename = 'Lisa.png';
            }
            else if ($character == 'homer') {
                $filename = 'Homer.png';
            }

            if ($filename) {
                print "<img src=images/$filename>";
            }

        ?>
        


        <form action="process.php" method="GET">
            <div>
                <p> What's your ideal job? </p>
                <select id = "job" name = "job">
                    <option value="empty">Select a job</option>
                    <option value="homer">Working at a bakery</option>
                    <option value="lisa">French tutor</option>
                    <option value="bart">Prank phone call specialist</option>
                </select>
            </div>

            <div>
                <p> What's your favorite food? </p>
                <select id="food" name="food">
                    <option value="empty">Select a food</option>
                    <option value="bart">Pizza</option>
                    <option value="homer">Donuts</option>
                    <option value="lisa">Apples</option>
                </select>
            </div>

            <div>
                <p> What's your favorite hobby? </p>
                <select id="activity" name="activity">
                    <option value="empty">Select a hobby</option>
                    <option value="bart">Skateboard</option>
                    <option value="homer">Sleep</option>
                    <option value="lisa">Study</option>
                </select>
            </div>

            <div>
                <p> What's your greatest fear?</p>
                <select id="fear" name="fear">
                    <option value="empty">Select a fear</option>
                    <option value="bart">Flying</option>
                    <option value="homer">Math problems</option>
                    <option value="lisa">Getting anything below an A in school</option>
                </select>
            </div>
            <br>
        </div>
            <input type="submit" value = "Which Simpsons Character am I?"></input>
        </form>
        <br>
        <a href="results.php">See Aggregate Results</a>
        
    </body>
</html>