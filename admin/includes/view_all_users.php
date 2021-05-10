<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>User_Id</th>
            <th>User_name</th>
            <th>First name</th>
            <th>Last_name</th>
            <th>Email</th>                                    
            <th>Image</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_users)){
                $user_id = $row['user_id'];
                $user_username = $row['username'];
                $user_firstName = $row['user_firstname'];
                $user_lastName = substr($row['user_lastname'],0,25);
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role']; 
                echo "<tr>";
                echo "<th>{$user_id}</th>";
                echo "<th>{$user_username}</th>";
                echo "<th>{$user_firstName}</th>";
                echo "<th>{$user_lastName}</th>";
                echo "<th>{$user_email}</th>";
                echo "<th><img width='100' src='../images/{$user_image}'alt='image'></th>";
                echo "<th>{$user_role}</th>";
                echo "<th><a href='users.php?change_to_admin={$user_id}'>Admin</a></th>";
                echo "<th><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></th>";
                echo "<th><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></th>";
                echo "<th><a href='users.php?delete={$user_id}'>Delete</a></th>";
                echo "</tr>";            
            }
        ?>
    </tbody>
</table>

<?php
    if(isset($_GET['change_to_admin'])){
        $the_user_id=$_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'Admin' WHERE user_id={$the_user_id}";
        $admin_query = mysqli_query($connection, $query);
        header("location: users.php");
    }
?>

<?php
    if(isset($_GET['change_to_sub'])){
        $the_user_id=$_GET['change_to_sub'];
        $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id={$the_user_id}";
        $subscriber_query = mysqli_query($connection, $query);
        header("location: users.php");
    }
?>

<?php
    if(isset($_GET['delete'])){
        $the_user_id=$_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("location: users.php");
    }
?>