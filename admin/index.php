<?php
    include "includes/admin_header.php";
?>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php
            include "includes/admin_navigation.php";
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the Admin
                            <small><?php echo $_SESSION['username']?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query = "SELECT COUNT(*) as num_of_posts FROM posts ";
                                        $num_of_posts_query = mysqli_query($connection, $query);
                                        while ($row = mysqli_fetch_assoc($num_of_posts_query)){
                                            $numOfPosts = $row['num_of_posts'];
                                        }
                                        ?>
                                        <div class='huge'><?php echo $numOfPosts;?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $query = "SELECT COUNT(*) as num_of_comments FROM comments ";
                                            $num_of_comments_query = mysqli_query($connection, $query);
                                            while ($row = mysqli_fetch_assoc($num_of_comments_query)){
                                                $numOfComments = $row['num_of_comments'];
                                            }
                                        ?>
                                        <div class='huge'><?php echo $numOfComments;?></div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php
                                        $query = "SELECT COUNT(*) as num_of_users FROM users ";
                                        $num_of_users_query = mysqli_query($connection, $query);
                                        while ($row = mysqli_fetch_assoc($num_of_users_query)){
                                            $numOfUsers = $row['num_of_users'];
                                        }
                                    ?>
                                        <div class='huge'><?php echo $numOfUsers;?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                        $query = "SELECT COUNT(*) as num_of_categories FROM categories ";
                                        $num_of_categories_query = mysqli_query($connection, $query);
                                        while ($row = mysqli_fetch_assoc($num_of_categories_query)){
                                            $numOfCategories = $row['num_of_categories'];
                                        }
                                    ?>
                                    <div class='huge'><?php echo $numOfCategories;?></div>
                                <div>Categories</div>
                            </div>
                        </div>
                    </div>
                    <a href="./categories.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php
            $query = "SELECT * FROM posts WHERE post_status = 'Published'";
            $select_all_Published_post = mysqli_query($connection,$query);
            $post_Published_count = mysqli_num_rows($select_all_Published_post);
 
            $query = "SELECT * FROM posts WHERE post_status = 'Draft'";
            $select_all_draft_post = mysqli_query($connection,$query);
            $post_draft_count = mysqli_num_rows($select_all_draft_post);

            $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
            $select_all_unapproved_comments = mysqli_query($connection,$query);
            $comments_unapproved_count = mysqli_num_rows($select_all_unapproved_comments);

            $query = "SELECT * FROM users WHERE user_role = 'Subscriber'";
            $select_all_Subscriber = mysqli_query($connection,$query);
            $Subscriber_count = mysqli_num_rows($select_all_Subscriber);
        ?>
        <div class="row">
            <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Data', 'Count'],
                    <?php 
                        $elements_text = ['Active Posts','Draft post','Post Published', 'Comments', 'Unapproved Comments' ,'Users', 'Subscribers users','Categories'];
                        $elements_count = [$numOfPosts, $post_draft_count ,$post_Published_count ,$numOfComments, $comments_unapproved_count ,$numOfUsers,$Subscriber_count, $numOfCategories];

                        for ($i=0; $i<7; $i++){
                            echo "['{$elements_text[$i]}'".","."{$elements_count[$i]}],";
                        }
                    ?>
                ]);
                
                var options = {
                    chart: {
                        title: '',
                        subtitle: '',}
                };
            
                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script> 
            <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
        </div>
    </div>
            <!-- /.container-fluid -->
</div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>