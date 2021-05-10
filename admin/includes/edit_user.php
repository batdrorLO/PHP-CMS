<?php
    if(isset($_GET['u_id'])){
        $the_user_id=$_GET['u_id'];
    }
    $query = "SELECT * FROM users WHERE user_id=${the_user_id}";
    $select_user_by_id = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_user_by_id)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
    if(isset($_POST['update_user'])){

        $username=$_POST['username'];
        $user_password=$_POST['user_password'];
        $user_firstname=$_POST['user_firstname'];
        $user_lastname=$_POST['user_lastname'];
        $user_email=$_POST['user_email'];
        $user_image=$_FILES['image']['name'];
        $user_image_temp=$_FILES['image']['tmp_name'];
        $user_role=$_POST['user_role'];

        move_uploaded_file($user_image_temp,"../images/$user_image");
        if(empty($user_image)){
            $query = "SELECT * FROM users WHERE user_id=$the_user_id";
            $select_image = mysqli_query($connection,$query);
            while ($row =mysqli_fetch_assoc($select_image)){
                $user_image = $row['user_image'];
            }
        }

        $query = "SELECT user_randSalt FROM users";
        $select_randSalt_query = mysqli_query($connection, $query);
        if(!$select_randSalt_query){
            die("Query Failed ".mysqli_error($connection));
        }

        $row = mysqli_fetch_array($select_randSalt_query);
        $randSalt = $row['user_randSalt'];
        $hashed_password = crypt($user_password, $randSalt);


        $query = "UPDATE users SET ";
        $query .="username = '{$username}', ";
        $query .="user_password = '{$hashed_password}', ";
        $query .="user_firstname = '{$user_firstname}', ";
        $query .="user_lastname = '{$user_lastname}', ";
        $query .="user_email = '{$user_email}', ";
        $query .="user_image = '{$user_image}', ";
        $query .="user_role = '{$user_role}' ";
        $query .="WHERE user_id={$the_user_id} ";
        $update_user_query = mysqli_query($connection, $query);
        confirm($update_user_query);
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class='form-group'>
        <label for="username">Username</label>
        <input value="<?php echo "{$username}";?>"type="text" class="form-control" name='username'>
    </div>

    <div class='form-group'>
        <label for="category">First Name</label>
        <input value="<?php echo "{$user_firstname}";?>"type="text" class="form-control" name='user_firstname'>
    </div>

    <div class='form-group'>
        <label for="user_lastname">Last Name</label>
        <input value="<?php echo "{$user_lastname}";?>"type="text" class="form-control" name='user_lastname'>
    </div>

    <div class='form-group'>
        <label for="user_password">Password</label>
        <input value="<?php echo "{$user_password}";?>"type="password" class="form-control" name='user_password'>
    </div>

    <div class='form-group'>
        <label for="post_image">Image</label>
        <input value="<?php echo "{$user_image}";?>"type="file" name='image'>
    </div>

    <div class='form-group'>
        <label for="user_email">Email</label>
        <input value="<?php echo "{$user_email}";?>"type="text" class="form-control" name='user_email'>
    </div>

    <div class='form-group'>
        <label for="user_role">Role</label>
        <select name="user_role" id="">
            <option value='option'><?php echo $user_role;?></option>
            <?php
                if($user_role == 'Admin'){
                   echo "<option value='subscriber'>Subscriber</option>";
                }  
                else {
                    echo "<option value='admin'>Admin</option>";
                }
            ?>    
        </select>
    </div>
    <div>
        <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
    </div>
</form>