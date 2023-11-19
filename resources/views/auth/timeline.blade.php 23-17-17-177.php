<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travellers - Timeline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #eee;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            border-radius: 50%;
            margin-right: 10px;
        }

        nav input[type="text"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 200px;
        }

        .buttons {
            text-align: center;
            margin: 20px 0;
        }

        .buttons button {
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 16px;
            color: #333;
            background-color: #eee;
        }

        .buttons button:hover {
            background-color: #ddd;
        }

        .buttons button.underline {
            text-decoration: underline;
        }

        /* Timeline styling can be added as per your design */

    </style>
</head>
<body>

    <header>
        <h1><a href="#">Travellers</a></h1>
    </header>

    <nav>
        <div>
            <img src="profile-picture.jpg" alt="Profile Picture" width="40" height="40">
            <span>Username</span>
        </div>
        <input type="text" placeholder="Search">
    </nav>

    <div class="buttons">
        <button class="underline">For you</button>
        <button>Following</button>
    </div>

    <!-- Your timeline content goes here -->

</body>
</html>
