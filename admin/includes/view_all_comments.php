<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>                                    
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT * FROM comments";
            $select_comments = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_comments)){
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_content = substr($row['comment_content'],0,25);
                $comment_email = $row['comment_email'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date']; 
                echo "<tr>";
                echo "<th>{$comment_id}</th>";
                echo "<th>{$comment_author}</th>";
                echo "<th>{$comment_content}</th>";
                echo "<th>{$comment_email}</th>";

            //    $query = "SELECT * FROM categories where cat_id = $post_category_id";
            //    $select_categories_byID = mysqli_query($connection, $query);
            //    while ($row = mysqli_fetch_assoc($select_categories_byID)){
            //        $cat_title = $row['cat_title'];
            //        $cat_id = $row['cat_id'];
//
            //    echo "<th>{$comment_email}</th>";}
//
                echo "<th>{$comment_status}</th>";
                ?>
                <?php
                    $query = "SELECT * from posts where post_id = $comment_post_id ";
                    $select_post_id_query = mysqli_query($connection, $query);
                    while ($row= mysqli_fetch_assoc($select_post_id_query)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        echo "<th><a href='../post.php?p_id={$post_id}'>$post_title</a></th>";
                    }

                ?>
                <?php
                echo "<th>{$comment_date}</th>";
                echo "<th><a href='comments.php?approve=$comment_id'>Approve</a></th>";
                echo "<th><a href='comments.php?unapprove=$comment_id'>Unapprove</a></th>";
                echo "<th><a href='comments.php?delete=$comment_id'>Delete</a></th>";
                echo "</tr>";            
            }
        ?>
    </tbody>
</table>

<?php
    if(isset($_GET['approve'])){
        $the_comment_id=$_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'Approve' WHERE comment_id={$the_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        header("location: comments.php");
    }
?>

<?php
    if(isset($_GET['unapprove'])){
        $the_comment_id=$_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'Unapprove' WHERE comment_id={$the_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        header("location: comments.php");
    }
?>

<?php
    if(isset($_GET['delete'])){
        $the_comment_id=$_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id= {$the_comment_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("location: comments.php");
    }
?>