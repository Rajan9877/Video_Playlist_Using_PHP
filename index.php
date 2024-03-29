<?php

include('config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        *{
            margin: 0px;
            padding: 0px;
            font-family: 'Poppins', sans-serif;
        }
        .heading{
            text-align: center;
            margin-top: 70px;
            margin-bottom: 15px;
        }
        .container{
            display: flex;
        }
        .left{
            width: 50vw;
            height: 100vh;
        }
        .right{
            width: 50vw;
            height: 100vh;
        }
        .videocontainer{
            text-align: center;
            background-color: rgb(228, 228, 228);
            padding-top: 15px;
            border-radius: 50px 50px 0px 0px;
            padding-bottom: 15px;
        }
        .videocontent{
            margin-left: 15px;
        }
        .videocontentcontainer{
            border: 2px solid grey;
            padding-bottom: 15px;
            border-radius: 50px;
            margin-right: 15px;
            
        }
        .videocontentcontainer div{
            border: 1px solid grey;
            padding: 10px;
            display: flex;
            margin-left: 50px;
            margin-right: 50px;
            border-radius: 50px;
            margin-top: 15px;
        }
        .videocontentcontainer div form button i{
            margin-top: 4px;
            margin-right: 7px;
        }
        .btn{
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
        #myVideo{
            border-radius: 15px;
        }
        #rightcontainer{
            border: 2px solid grey;
            margin-left: 15px;
            margin-right: 15px;
            border-radius: 50px;
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
            <div><h3>Playlist</h3></div>
            <div><a href="http://localhost/playlist/upload/">Upload Video</a></div>
        </div>
    </nav>
    <h1 class="heading">Video Playlist</h1>
    <div class="container">
        <div class="right" id="rightcontainer">
                <?php
                    $query1 = "SELECT * FROM videos WHERE id = 1";
                    $result1 = mysqli_query($conn, $query1);
                    while ($row = mysqli_fetch_assoc($result1)) {
                ?>
            <div class="videocontainer">
                <video id="myVideo" src="videos/<?php echo $row['videosrc'];  ?>" controls controlsList="nodownload" autoplay muted width="550px"></video>
            </div>
            <hr>
            <br>
            <div class="videocontent">
                <h2><?php  echo $row['title'];  ?></h2>
                <br>
                <p><?php echo $row['description'];  ?></p>
            </div>
            <?php
                 }
            ?>
        </div>
        <div class="left">
            <div class="videocontentcontainer">
            <?php
            $query2 = "SELECT * FROM videos";
            $result2 = mysqli_query($conn, $query2);
            if(mysqli_num_rows($result2) > 0){
                while($row = mysqli_fetch_assoc($result2)){
            ?>
                <div>
                    <form class="videoform" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']  ?>">
                        <button class="btn" id="btn<?php echo $row['id'] ?>"><i class="fa-solid fa-play" id="fa<?php echo $row['id'] ?>"></i></button>
                    </form>
                    <h4 class='videotitle' id="<?php echo $row['id']?>"><?php echo $row['title']; ?></h4>
                </div>
            <?php
                 }
                }
            ?>
            </div>
        </div>
    </div>
    <footer>
        <div>Copyright &copy; <?php echo date('Y'); ?> | Created By Rajan</div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    var video = document.getElementById("myVideo");
    video.addEventListener("ended", function() {
        $('#btn2').trigger('click');
        // Add your logic here for what to do when the video ends
    });
    function attachEndedListener() {
    var video = document.getElementById("myVideo");
    video.addEventListener("ended", function() {
        $('.addbtn').trigger('click');
        // Add your logic here for what to do when the video ends
    });
}
    $('#1').css('color', 'red');
    $('#fa1').removeClass('fa-play')
    $('#fa1').addClass('fa-pause')
        // this is the id of the form
    $(".videoform").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);

    $.ajax({
        type: "POST",
        url: "onevideo.php",
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
        const obj = JSON.parse(data);
        var intid = parseInt(obj.id)
        $('#rightcontainer').html('<div class="videocontainer"><video id="myVideo" src="videos/'+ obj.videosrc +'" controls controlsList="nodownload" autoplay muted width="550px"></video></div><br><hr><br><div class="videocontent"><h2>'+ obj.title +'</h2><br><p>'+ obj.description +'</p></div></div>');
        $('.videotitle').css('color', 'black');
        $('#'+obj.id+'').css('color', 'red');
        $('.fa-pause').addClass("fa-play");
        $('.fa-pause').removeClass("fa-pause");
        $('#fa'+obj.id+'').removeClass('fa-play');
        $('#fa'+obj.id+'').addClass('fa-pause');
        $('.addbtn').removeClass('addbtn');
        if( document.getElementById('btn'+(intid+1)+'') !== null){
        $('#btn'+(intid+1)+'').addClass('addbtn');
        }else{
            var video = document.getElementById("myVideo");
        video.addEventListener("ended", function() {
        $('#btn1').trigger('click');
    });
        }   
        attachEndedListener();
        }
    });
    });
    </script>
  
</body>
</html>