<?php 
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueID){
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options) {
                case 'published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueID} ";
                    $update_to_published = mysqli_query($connection, $query);
                    confirm($update_to_published);
                    break;
                case 'draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueID} ";
                    $update_to_draft = mysqli_query($connection, $query);
                    confirm($update_to_draft);
                    break;
                case 'delete':
                    $query = "DELETE * FROM posts WHERE post_id = {$postValueID} ";
                    $delete_posts_query = mysqli_query($connection, $query);
                    confirm($delete_posts_query);
                    break;
                case 'clone':
                    $query = "SELECT * FROM posts WHERE post_id = {$postValueID} ";
                    $select_post_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_post_query)){
                        $post_title       = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_date        = $row['post_date'];
                        $post_author      = $row['post_author'];
                        $post_status      = $row['post_status'];
                        $post_image       = $row['post_image'];
                        $post_tags        = $row['post_tags'];
                        $post_content     = $row['post_content'];
                    }
                    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags,post_status) " ;
                    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
                    $copy_query = mysqli_query($connection, $query);
                    if(!$copy_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    break;
            }
        }
   } 
?>
<form action="" method='post'>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">Select Option
                <option value="">Select Option</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">New Post</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>                                    
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Reset Views</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM posts ORDER by post_id desc";
                $select_posts = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_posts)){
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
                    $post_views_count = $row['post_views_count'];  
                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' type='checkbox' name="checkBoxArray[]" value='<?php echo $post_id;?>'></td>
                    <?php
                    echo "<th>{$post_id}</th>";
                    echo "<th>{$post_author}</th>";
                    echo "<th>{$post_title}</th>";

                    $query = "SELECT * FROM categories where cat_id = $post_category_id";
                    $select_categories_byID = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_categories_byID)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                    echo "<td>{$cat_title}</td>";}

                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/{$post_image}'alt='image'></td>";
                    echo "<td>{$post_tags}</td>";
                    echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to reset views?');\" href='posts.php?reset_views={$post_id}'>{$post_views_count}</a></td>";
                    echo "<td><a href='../post.php?post&p_id={$post_id}'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                    echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "</tr>";            
                }
            ?>
        </tbody>
    </table>
</form>
<?php
    if(isset($_GET['delete'])){
        $the_post_id=$_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id=$the_post_id";
        $delete_query = mysqli_query($connection, $query);
        confirm($query);
        header("location: posts.php");
    }
?>
<?php
    if(isset($_GET['reset_views'])){
        $the_post_id=$_GET['reset_views'];
        $query = "UPDATE posts SET post_views_count = 0  WHERE post_id=$the_post_id";
        $reset_views_query = mysqli_query($connection, $query);
        confirm($query);
        header("location: posts.php");
    }
?>