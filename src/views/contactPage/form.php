<?php

// This is the template for the contact form

?>

<div class="contact-page-container">

    <div class="form">
        <div class="contact-header">
            <i class="far fa-comments"></i>
            <div class="header-text">
                Got something you want to ask or say?<br>Let's get in touch
            </div>
        </div>

        <form>
            <div class="form-group">
                <label for="name">Your name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Your contact email</label>
                <input type="email" class="form-control" id="email" placeholder="Your email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <div class="current-message-length"><span>0</span> of 1000</div>
                <textarea class="form-control" id="message" rows="10" required maxlength="1000"></textarea>
            </div>
            <div class="button-container">
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
            <div class="form-status-messages">
                <span class="text-danger"></span>
            </div>
        </form>
    </div>

    <div class="sent-success">
        <i class="fa fa-thumbs-up"></i>
        <div class="message">Thank you!<br>Your message was submitted successfully.</div>
    </div>
</div>

<script src="/src/public/js/contactPage.js"></script>

<?php $csrfToken = \Blog\Auth::getCSRFToken(); ?>
<div data-csrf-token="<?= $csrfToken ?>"></div>