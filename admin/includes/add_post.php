<?php

    if(isset($_POST['create_post'])){
        $post_title = $_POST['title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp=$_FILES['image']['tmp_name'];
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date= date('d-m-y');
        
        
        move_uploaded_file($post_image_temp, "../images/$post_image");
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,post_status) ";
        $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
        $creat_post_query = mysqli_query($connection,$query);
        confirm($creat_post_query);

        $post_id = mysqli_insert_id($connection);
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>Add Post </a>Or <a href='posts.php'>Add More Posts</a></p>";

    }
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class='form-group'>
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name='title'>
    </div>

    <div class='form-group'>
        <label for="category">Post Category</label>
        <select name="post_category" id="">
            <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                confirm($select_categories);
                while ($row = mysqli_fetch_assoc($select_categories)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>
            
        </select>
    </div>

    <div class='form-group'>
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name='post_author'>
    </div>

    <div class='form-group'>
        <select name="post_status" id="">
            <option value="Draft">Post Status</option>
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
        </select>
    </div>

    <div class='form-group'>
        <label for="post_image">Post Image</label>
        <input type="file" name='image'>
    </div>

    <div class='form-group'>
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name='post_tags'>
    </div>

    <div class='form-group'>
        <label for="title">Post content</label>
        <textarea class='form-control' name='post_content' id="body" cols="30" rows="10">
</textarea>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>