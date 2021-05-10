
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
                $the_post_author = $_GET['author'];
            }
                $query = "SELECT * FROM posts where post_author = '{$the_post_author}'";
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
                   All Posts by <?php echo $post_author;?>
                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span> <?php echo $post_date;?>
                </p>
                <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                    <p><?php echo $post_content;?></p>
                <hr>
                <?php } ?>
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