<?php if (has_nav_menu('main_menu')) : ?>
<div class="header__bottom">
    <div class="container container--xl-padding">
        <div class="row">
            <div class="dmbs-top-menu col-sm-12">
                <nav class="navbar navbar-default" role="navigation">
                    <a class="header__logo--mobile"
                       href="<?php echo esc_url(home_url('/')); ?>"><img
                                src="<?php echo esc_url(home_url('/')); ?>/wp-content/themes/devdmbootstrap3-child/img/EPIC2022 Logo.svg"></a>


                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle"
                                data-toggle="collapse"
                                data-target=".navbar-1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-1-collapse">
                      <?php
                      wp_nav_menu(array(
                          'theme_location' => 'main_menu',
                          'depth' => 2,
                          'container' => '',
                          'container_class' => '',
                          'menu_class' => 'nav navbar-nav',
                          'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                          'walker' => new wp_bootstrap_navwalker()
                        )
                      );
                      ?>
                        <!--<form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="s" id="search" value="<?php the_search_query(); ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>-->
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>


<?php endif; ?>
