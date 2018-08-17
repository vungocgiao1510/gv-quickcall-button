<form method="POST" action="options.php">
    <?php
    settings_fields( 'quickcall_group' );
    do_settings_sections( 'quickcall_page' );
    submit_button();
    ?>
</form>