<?php

function confirm($result){
    global $connection;
    if(!$result){
        die("Query Failed!" . mysqli_error($connection));
    }
}

function addCategory (){
    global $connection;
    if (isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        //echo "$cat_title";
        if($cat_title =="" || empty($cat_title)){
            echo "This field should not be empty!";
        }
        else {
            $query = "INSERT into categories(cat_title) ";
            $query .= "VALUE('{$cat_title}') ";
            $create_catagory_query = mysqli_query($connection,$query);
            if (!$create_catagory_query){
                die('Query Failed' . mysqli_error());
            }
        }
    }
}
function deleteCategory(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE from categories where cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("location: categories.php");
    }
}


function showCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    } 
}
?>