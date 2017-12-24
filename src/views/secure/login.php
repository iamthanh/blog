<?php // Template for the header ?>

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
        <div class="message-container"></div>
    </form>
</div>