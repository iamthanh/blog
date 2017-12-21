<?php // Template for the header ?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans|Quicksand:300,400|Raleway" rel="stylesheet">
    <link rel="stylesheet" href="/src/public/css/secure.css">
    <script src="https://use.fontawesome.com/ea714fcd83.js"></script>
</head>
<body>
    <div class="login-container">
        <form class="form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="username" class="form-control" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="submit-button-container">
                <button type="submit" class="btn btn-blue">Submit</button>
            </div>
            <div class="form-message-container"></div>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/src/public/js/login.js"></script>
</body>
</html>

