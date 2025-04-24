<?php
//status message
$statusMessage = '';
$statusClass = '';

//status parameter
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'added':
            $statusMessage = 'Movie successfully added to the database!';
            $statusClass = 'success-message';
            break;
        case 'deleted':
            $statusMessage = 'Movie successfully deleted from the database!';
            $statusClass = 'success-message';
            break;
    }
}

?>

<!-- landing page -->
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 8</title>
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
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
        
        .delete-btn {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .delete-btn:hover {
            color: #c0392b;
            text-decoration: underline;
        }
        
        /* Empty table state */
        .empty-table-message {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
 </head>
 <body>
 <h1>Movie Database</h1>
 <div id = "navbar">
    <a href="index.php">View All</a>
    <a href="add_form.php">Add Movie</a> 
    <a href="search_form.php">Search Movies</a>
 </div>

 <?php if (!empty($statusMessage)): ?>
    <div class="<?php echo $statusClass; ?>" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center;">
        <?php echo $statusMessage; ?>
    </div>
<?php endif; ?>

    <table>
        <tr>
            <td>Title</td>
            <td>Year</td>
            <td>Options</td>
        </tr>
        <?php

        $db = new SQLite3('/home/ahc9434/databases/movies.db');
        $sql = "SELECT id, title, year FROM movies ORDER BY title, year";
        $statement = $db -> prepare($sql);
        $result = $statement -> execute();

        $hasRows = false;

        // render movie records into the table
        while ($row = $result->fetchArray()) {
            $hasRows = true;
            $id = $row[0];
            $title = $row[1];
            $year = $row[2];

            print "<tr>";
            print "    <td>$title</td>";
            print "    <td>$year</td>";
            print "    <td><a href='delete.php?id=$id' class='delete-btn' >DELETE</a></td>";
            print "</tr>";
        }

        if (!$hasRows) {
            print "<tr><td colspan='3' class='empty-table-message'>No movies found in the database.</td></tr>";
        }

        $db->close();
        unset($db);

        ?>
    </table>
    
 </body>
 </html>
