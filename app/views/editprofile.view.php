<?php 
$x=new Update();
$x->connection(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
$profile=$x->getUserByUsername($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update profile</title>
    <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/createpost.css">
</head>

<body>
    <div class="container">
        <div class="post-form">
            <h2>Edit Profile</h2>
            <form id="post-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Select Profile Image</label>
                    <input type="file" name="filetoupload">
                </div>
                <div class="form-group">
                    <label for="description">Edit Bio:</label>
                    <textarea id="description" name="description"
                        placeholder="Enter your Bio for your Profile here..."><?php echo $profile['bio']?></textarea>
                </div>
                <div class="form-group">
                <label for="description">Edit Email:</label>
                <input type="text" name="email" value='<?=$profile['email']?>'>
                </div>
                <div class="form-group">
                <label for="description">Edit User_name:</label>
                <input type="text" name="username" value='<?=$profile['UserName']?>' >
                </div>
                <input class="create_button" name="submit" type="submit" value="Update Profile" ></button>
                <div class="links">
                <a href="profile" class="go">Go to Profile</a>
                </div>
            </form>
        </div>
    </div>

    <div id="post-container"></div>
</body>

</html>