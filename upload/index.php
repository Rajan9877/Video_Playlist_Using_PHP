<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;1,500&display=swap" rel="stylesheet">
    <title>Upload Video To Add In The Playlist</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
            font-family: 'Poppins', sans-serif;
        }
        .heading{
            margin-top: 15px;
            text-align: center;
            color: red;
        }
        .container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container form{
            display: flex;
            flex-direction: column;
        }
        .container form label{
            font-size: 20px;
            margin-bottom: 3px;
        }
        .container form input{
            padding: 10px;
            border-radius: 50px;
            outline: none;
        }
        .btn{
            padding: 10px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            background-color: red;
            color: white;
            transition: all 0.5s;
        }
        .btn:hover{
            border: 1px solid red;
            color: red;
            background-color: transparent;
        }
        input[type="file"]::file-selector-button{
            padding: 10px;
            border-radius: 50px;
            border: none;
            background-color: red;
            color: white;
            cursor: pointer;
            transition: all 0.5s;
        } 
        input[type="file"]::file-selector-button:hover{
            background-color: transparent;
            border: 1px solid red;
            color: red;
        }
        input[type="text"]{
            border: 1px solid red;
        }
        nav{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            background-color: white;
            z-index: 1000;
        }
        nav div{
            display: flex;
            justify-content: space-between;
            padding: 10px;
            color: red;
        }
        nav div div a{
            text-decoration: none;
            color: red;
            transition: all 0.5s;
        }
        nav div div a:hover{
            color: black;
        }
        footer{
            background-color: red;
            margin-top: 30px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 7px;
        }
    </style>
</head>
<body>
    <nav>
        <div>
            <div><a href="http://localhost/playlist"><h3>Playlist</h3></a></div>
        </div>
    </nav>
    <div class="container">
    <h2 class="heading">Upload Video To Add In The Playlist</h2>
    <?php
    include("../config.php");
    if(isset($_POST['upload'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $targetDir = "../videos/";
        $fileName = $_FILES["filetoupload"]["name"];
        $targetFilePath = $targetDir . $fileName;
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if($ext == "mp4"){
        $query = "INSERT INTO `videos` (`title`, `description`, `videosrc`) VALUES ('$title', '$description', '$fileName')";
        mysqli_query($conn, $query);
        move_uploaded_file($_FILES["filetoupload"]["tmp_name"], $targetFilePath);
        echo("<p style='text-align: center; color: green;'>Your file has been uploaded successfully.</p>");
        }else{
            echo "<p style='text-align: center; color: red;'>Your file can't be uploaded.</p>";
        }
        
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title : </label>
        <input type="text" name="title" id="title" placeholder="Enter Video Title">
        <label for="description">Description : </label>
        <input type="text" name="description" id="description" placeholder="Enter Video Description">
        <label for="video">Video : </label>
        <input type="file" name="filetoupload" id="video">
        <button class="btn" name="upload">Upload</button>
    </form>
    </div>
    <footer>
        <div>Copyright &copy; <?php echo date('Y'); ?> | Created By Rajan</div>
    </footer>
</body>
</html>