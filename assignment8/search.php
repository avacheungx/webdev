<?php
//get search parameters from URL
$searchTitle = isset($_GET['title']) ? trim($_GET['title']) : '';
$searchYear = isset($_GET['year']) ? trim($_GET['year']) : '';

//perform search if at least one parameter is provided
$searchPerformed = !empty($searchTitle) || !empty($searchYear);

$searchResults = [];

if ($searchPerformed) {
    //connect to the database
    $db = new SQLite3('/home/ahc9434/databases/movies.db');

    //build the SQL query 
    $sql = "SELECT id, title, year FROM movies WHERE 1=1";
    $params = [];

    // Add title
    if (!empty($searchTitle)) {
        $sql .= " AND title LIKE :title";
        $params[':title'] = '%' . $searchTitle . '%';
    }

    // Add year
    if (!empty($searchYear)) {
        $sql .= " AND year = :year";
        $params[':year'] = (int)$searchYear;
    }

    // sorting
    $sql .= " ORDER BY title, year";

    $statement = $db->prepare($sql);

    //bind parameters
    foreach ($params as $param => $value) {
        if ($param === ':year') {
            $statement->bindValue($param, $value, SQLITE3_INTEGER);
        } else {
            $statement->bindValue($param, $value, SQLITE3_TEXT);
        }
    }

    $result = $statement->execute();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $searchResults[] = $row;
    }

    $db->close();
    unset($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
        
        .search-summary {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .no-results {
            text-align: center;
            padding: 40px 20px;
            background-color: white;
            border-radius: 8px;
            margin-top: 20px;
            color: #7f8c8d;
            font-style: italic;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #95a5a6;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .back-btn:hover {
            background-color: #7f8c8d;
        }

        #search-form {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
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
    </style>
</head>
<body>
    <h1>Search Results</h1>
    <div id="navbar">
        <a href="index.php">View All</a>
        <a href="add_form.php">Add Movie</a>
        <a href="search_form.php">Search Movies</a>
    </div>
    
    <div id="search-form">
        <form action="search.php" method="GET">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($searchTitle); ?>">
            </div>
            <div>
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($searchYear); ?>">
            </div>
            <button type="submit">Search</button>
        </form>
    </div>
    
    <?php if ($searchPerformed): ?>
        <div class="search-summary">
            <?php
            $criteria = [];
            if (!empty($searchTitle)) {
                $criteria[] = "Title contains \"" . $searchTitle . "\"";
            }
            if (!empty($searchYear)) {
                $criteria[] = "Year is " . $searchYear;
            }
            
            echo "Search criteria: " . implode(" AND ", $criteria);
            ?>
        </div>
        
        <?php if (empty($searchResults)): ?>
            <div class="no-results">
                <p>No movies found matching your search criteria.</p>
            </div>
        <?php else: ?>
            <p>Found <?php echo count($searchResults); ?> movie(s) matching your criteria:</p>
            
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $movie): ?>
                        <tr>
                            <td><?php echo $movie['title']; ?></td>
                            <td><?php echo $movie['year']; ?></td>
                            <td>
                                <a href="delete.php?id=<?php echo $movie['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this movie?')">DELETE</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>