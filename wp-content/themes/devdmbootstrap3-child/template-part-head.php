<?php global $dm_settings; ?>


<?php if ($dm_settings['show_header'] != 0) : ?>
    <div class="header__top">
        <div class="container container--xl-padding">
            <div class="row">
                <div class="header__logo-placement col-md-6">
                    <a class="
                    header__logo"
                       href="<?php echo esc_url(home_url('/')); ?>"><img
                                src="<?php echo esc_url(home_url('/')); ?>wp-content/themes/devdmbootstrap3-child/img/EPIC2022 Logo.svg"></a>
                </div>

                <div class="masthead-copy col-md-6">
                    <div class="masthead__inner">
                        <span class="masthead__location">Amsterdam, Netherlands</span><br/>
                        <span class="masthead__location-date">October 9–12, 2022</span><br/>
                    </div class=masthead__inner">
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
