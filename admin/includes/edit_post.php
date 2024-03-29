<?php
    if(isset($_GET['p_id'])){
        $the_post_id=$_GET['p_id'];
    }
    $query = "SELECT * FROM posts WHERE post_id=${the_post_id}";
    $select_post_by_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_post_by_id)){
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
    }
    if(isset($_POST['update_post'])){

        $post_author=$_POST['post_author'];
        $post_title=$_POST['post_title'];
        $post_category_id=$_POST['post_category'];
        $post_status=$_POST['post_status'];
        $post_image=$_FILES['image']['name'];
        $post_image_temp=$_FILES['image']['tmp_name'];
        $post_content=$_POST['post_content'];
        $post_tags=$_POST['post_tags'];

        move_uploaded_file($post_image_temp,"../images/$post_image");
        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id=$the_post_id";
            $select_image = mysqli_query($connection,$query);
            while ($row =mysqli_fetch_assoc($select_image)){
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET ";
        $query .="post_title = '{$post_title}', ";
        $query .="post_category_id = '{$post_category_id}', ";
        $query .="post_date = now(), ";
        $query .="post_author = '{$post_author}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_tags = '{$post_tags}', ";
        $query .="post_content = '{$post_content}', ";
        $query .="post_image = '{$post_image}' ";
        $query .="WHERE post_id={$the_post_id} ";
        $update_post_query = mysqli_query($connection, $query);
        confirm($update_post_query);


        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>View Post </a>Or <a href='posts.php'>Edit More Posts</a></p>";
    }
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class='form-group'>
        <label for="post_title">Post Title</label>
        <input value="<?php echo "{$post_title}";?>" type="text" class="form-control" name='post_title'>
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
        <input value="<?php echo "{$post_author}";?>"type="text" class="form-control" name='post_author'>
    </div>

    <div class='form-group'>
        <label for="post_status">Post Status</label>
        <select name="post_status" id="">
            <option value=''><?php echo $post_status;?></option>
            <?php 
                if ($post_status === 'Published'){
                    echo "<option value='draft'>Draft</option>";
                }
                else {
                    echo "<option value='Published'>Published</option>";
                }
            ?>
        </select>
    </div>

    <div class='form-group'>
        <img width="100" src="../images/<?php echo $post_image;?>">
    </div>

    <div class='form-group'>
        <label for="post_image">Post Image</label>
        <input type="file" name='image'>
    </div>

    <div class='form-group'>
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo "{$post_tags}";?>" type="text" class="form-control" name='post_tags'>
    </div>

    <div class='form-group'>
        <label for="title">Post content</label>
        <textarea class='form-control' name='post_content' id="" cols="30" rows="10"><?php echo "{$post_content}";?> </textarea>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>