
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Input for Post</title>
    <link rel="stylesheet" href="<?= ROOT ?>/public/assests/css/createpost.css">
</head>

<body>
    <div class="container">
        <div class="post-form">
            <h2>Create a Post</h2>
            <form id="post-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Select Image</label>
                    <input type="file" name="filetoupload" required>
                </div>
                <div class="form-group">
                    <label for="description">Add Caption:</label>
                    <textarea id="description" name="description"
                        placeholder="Enter your Bio for image here..." ></textarea>
                </div>
                <input class="create_button" name="submit" type="submit" value="Create Post" ></button>
            </form>
        </div>
    </div>

    <div id="post-container"></div>
</body>

</html>