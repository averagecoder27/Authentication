<?php 

require('connection.php');
session_start();

// Login
if(isset($_POST['login']))
{
    $query="SELECT * FROM `registered_users` WHERE `email`='$_POST[email_username]' OR `username`='$_POST[email_username]'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result)==1)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if(password_verify($_POST['password'],$result_fetch['password']))
            {
                $_SESSION['logged_in']=true;
                $_SESSION['username']=$result_fetch['username'];
                header("location: index.php");
            }
            else
            {
                echo"
                    <script>
                        alert('Incorrect Password');
                        window.location.href='index.php';
                    </script>
                ";
            }
        }
        else
        {
            echo"
                <script>
                    alert('Username or Email has not been registered. Please register');
                    window.location.href='index.php';
                </script>
            ";
        }
    }
    else
    {
        echo"
            <script>
                alert('Query can not be executed');
                window.location.href='index.php';
            </script>
        ";
    }
}





// Registration
if(isset($_POST['register']))
{
    $user_exist_query="SELECT * FROM `registered_users` WHERE `username`='$_POST[username]' OR `email`='$_POST[email]'";
    $result=mysqli_query($con,$user_exist_query);

    if($result)
    {
        if(mysqli_num_rows($result)>0)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['username']==$_POST['username'])
            {
                echo"
                    <script>
                        alert('$result_fetch[username] - Username already taken');
                        window.location.href='index.php';
                    </script>
                ";
                    
            }
            else
            {
                echo"
                    <script>
                        alert('$result_fetch[email] - Email already registered');
                        window.location.href='index.php';
                    </script>
                ";
            }
        }
        else
        {
            $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
            $query="INSERT INTO `registered_users`(`full_name`, `username`, `email`, `password`) VALUES('$_POST[fullname]','$_POST[username]','$_POST[email]','$password')";
            if(mysqli_query($con,$query))
            {
                echo"
                    <script>
                        alert('Registered Succesfully');
                        window.location.href='index.php';
                    </script>
                ";
            }
            else
            {
                echo"
                    <script>
                        alert('Query can not be executed');
                        window.location.href='index.php';
                    </script>
                ";
            }
        }
    }
    else
    {
        echo"
            <script>
                alert('Query can not be executed');
                window.location.href='index.php';
            </script>
        ";
    }
}

?>