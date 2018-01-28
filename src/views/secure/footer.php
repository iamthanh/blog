<?php // The footer template for secure paths ?>

<?php $csrfToken = \Blog\Auth::getCSRFToken(); ?>

<div data-token="<?= $csrfToken ?>"></div>

</body>
</html>


