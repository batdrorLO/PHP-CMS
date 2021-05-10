 <form action="" method="post">
    <div class="form-group">
        <lable for='cat-title'>Edit Catagory</lable>
        <?php
            if (isset($_GET['edit'])){
                $cat_id = $_GET['edit']; 
                $query = "SELECT * FROM categories where cat_id = $cat_id ";
                $select_categories_byID = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories_byID)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
        ?>
        <input value="<?php if (isset($cat_title)){echo $cat_title;}?>"type="text" class="form-control" name="cat_title">
    <?php }} ?>
    <?php
        if(isset($_POST['update_catagory'])){
            $the_cat_title = $_POST['cat_title'];
            $query = "UPDATE categories SET cat_title='{$the_cat_title}' where cat_id = $cat_id";
            $update_query = mysqli_query($connection,$query);
        }
    ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_catagory" value="Update Catagory">
    </div>
</form>