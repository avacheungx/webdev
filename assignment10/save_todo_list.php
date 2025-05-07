<?php
//get the todo data from the request
$todoData = $_POST['todoData'];

//save the data to a file
file_put_contents('todo_list.json', $todoData);

//return success response
echo json_encode(['success' => true]);
?>