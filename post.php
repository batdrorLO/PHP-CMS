
<?php include "includes/header.php";?>

<body>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php
            if(isset($_GET['p_id'])){
                $the_post_id=$_GET['p_id'];
                
                $view_query ="UPDATE posts SET post_views_count = post_views_count+1 WHERE post_id = {$the_post_id}";
                $send_query = mysqli_query($connection, $view_query);

                $query = "SELECT * FROM posts where post_id = $the_post_id";
                $select_post_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_post_query)){
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
            ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title;?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author;?></a>
                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span> <?php echo $post_date;?>
                </p>
                <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                    <p><?php echo $post_content;?></p>
                <hr>
                <?php }
                }else {
                    header("Location: index.php");
                } ?>
                <!-- Blog Comments -->
                <?php
                    if(isset($_POST['create_comment'])){
                        $the_post_id = $_GET['p_id'];
                        $comment_author=$_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        if(!empty($comment_author)&& !empty($comment_email) && !empty($comment_content))
                        {
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                            $query .= "VALUES($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                            $creat_comment_query = mysqli_query($connection,$query);
                            if (!$creat_comment_query){
                                die("Query Failed". mysqli_error());
                            }

                            $query = "UPDATE posts SET post_comment_count = post_comment_count+1 ";
                            $query .= "where post_id = $the_post_id";
                            $update_comment_count_query = mysqli_query($connection, $query);
                            if (!$update_comment_count_query){
                                die("Query Failed". mysqli_error());
                            }
                        }
                        else {
                            echo "<script>alert('Field cannot be empty')</script>/>";
                        }
                    }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" name="comment_author" >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="comment_email" >
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name = "create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id ";
                    $query .= "AND comment_status= 'Approve' ";
                    $query .= "ORDER BY comment_id desc";
                    $approve_comments_query = mysqli_query($connection, $query);
                    if(!$approve_comments_query){
                        die("Quert Failed" . mysqli_error());
                    }
                    while ($row = mysqli_fetch_assoc($approve_comments_query)){
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];

                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo "$comment_author"; ?>
                            <small><?php echo "$comment_date"; ?></small>
                        </h4>
                            <?php echo "$comment_content"; ?>                    
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>