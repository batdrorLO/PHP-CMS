<?php

    if(isset($_POST['create_user'])){
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        
        $user_image = $_FILES['image']['name'];
        $user_image_temp=$_FILES['image']['tmp_name'];
        
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];
        
        
        move_uploaded_file($user_image_temp, "../images/$user_image");
        $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image,user_role) ";
        $query .= "VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_image}','{$user_role}')";
        $creat_user_query = mysqli_query($connection,$query);
        confirm($creat_user_query);

        echo "User Created: " . " " . "<a href='users.php'>View Users</a>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class='form-group'>
        <label for="username">Username</label>
        <input type="text" class="form-control" name='username'>
    </div>

    <div class='form-group'>
        <label for="category">First Name</label>
        <input type="text" class="form-control" name='user_firstname'>
    </div>

    <div class='form-group'>
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name='user_lastname'>
    </div>

    <div class='form-group'>
        <label for="user_password">Password</label>
        <input type="text" class="form-control" name='user_password'>
    </div>

    <div class='form-group'>
        <label for="post_image">Image</label>
        <input type="file" name='image'>
    </div>

    <div class='form-group'>
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name='user_email'>
    </div>

    <div class='form-group'>
        <label for="user_role">Role</label>
        <select name="user_role" id="">
            <option value='option'>Select Option</option>
            <option value='subscriber'>Subscriber</option>
            <option value='admin'>Admin</option>
        </select>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>