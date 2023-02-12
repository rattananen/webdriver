<?php
sleep(1);
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        .left {
            background-color: #2196F3;
            padding: 20px;
            float: left;
            width: 20%;
            /* The width is 20%, by default */
        }

        .main {
            background-color: #f1f1f1;
            padding: 20px;
            float: left;
            width: 60%;
            /* The width is 60%, by default */
        }

        .right {
            background-color: #04AA6D;
            padding: 20px;
            float: left;
            width: 20%;
            /* The width is 20%, by default */
        }

        /* Use a media query to add a break point at 800px: */
        @media screen and (max-width: 800px) {

            .left,
            .main,
            .right {
                width: 100%;
                /* The width is 100%, when the viewport is 800px or smaller */
            }
        }
    </style>
</head>

<body>
    <h1>1 second</h1>
    <div class="left">
        Left Menu
    </div>

    <div class="main">
        Main Content with image
        <img class="common-img" src="400x150.png"/>
    </div>

    <div class="right">
        Right Content
    </div>
</body>
</html>