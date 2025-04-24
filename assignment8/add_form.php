<?php
//initialise error message
$errorMessage = '';
$errorClass = 'error-message';

//status parameter
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'error':
            $errorMessage = 'Please fill out all required fields!';
            break;
        case 'invalid_year':
            $errorMessage = 'Year must be a number!';
            break;
        case 'failed':
            $errorMessage = 'Failed to add movie to the database. Please try again.';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        #navbar {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        #navbar a {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: 500;
            border: none;
        }
        
        #navbar a:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        #inputContainer {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align:center;
        }
        
        label {
            display: inline-block;
            font-weight: bold;
            margin-right: 10px;
            min-width: 60px;
        }
        
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 20px;
            margin-bottom: 15px;
            width: 200px;
        }
        
        button {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-top: 10px;
            display: inline-block;
            margin-left: auto;
            margin-right: auto;
        }
        
        button:hover {
            background-color: #27ae60;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Movie Database</h1>
    <div id="navbar">
        <a href="index.php">View All</a>
        <a href="add_form.php">Add Movie</a> 
        <a href="search_form.php">Search Movies</a>
    </div>
    <div id="inputContainer">
        <?php if (!empty($errorMessage)): ?>
            <div class="<?php echo $errorClass; ?>" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center;">
                <?php echo ($errorMessage); ?>
            </div>
        <?php endif; ?>
        
        <form action="add_movie.php" method="POST">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title">
            </div>
            <div>
                <label for="year">Year:</label>
                <input type="text" id="year" name="year">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>