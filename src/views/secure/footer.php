<?php // The footer template for secure paths ?>

<?php $csrfToken = \Blog\Auth::getCSRFToken(); ?>

<div data-token="<?= $csrfToken ?>"></div>
<script type="text/javascript" src="/src/public/js/login.js"></script>

</body>
</html>


