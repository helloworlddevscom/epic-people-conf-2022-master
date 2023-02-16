       

<?php
    global $dm_settings;
    if ($dm_settings['left_sidebar'] != 0) : ?>
    <div class="col-md-<?php echo $dm_settings['left_sidebar_width']; ?> cfp-left no-pad col-md-pull-8">
        <?php dynamic_sidebar( 'Left Sidebar' ); ?>
    </div>
<?php endif; ?>
