<?php
//check if the todo list file exists
if (file_exists('todo_list.json')) {
    //read file contents
    $todoData = file_get_contents('todo_list.json');
    
    //return the todo list data
    echo $todoData;
} else {
    //return empty lsit
    echo json_encode(['items' => []]);
}
?>