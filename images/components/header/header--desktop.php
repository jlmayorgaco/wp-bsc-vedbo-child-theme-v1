
<?php
function render_dropdown_menu($menu_slug) {
    // Retrieve menu items by menu slug
    $menu_items = wp_get_nav_menu_items($menu_slug);
    if (!$menu_items) return;

    echo '<li class="bsc__dropdown">';
    echo '<a href="#" class="dropdown-toggle">' . ucwords(str_replace('_', ' ', str_replace('BSC_MENU_', '', $menu_slug))) . ' <span>&#9662;</span></a>';
    
    // Dropdown menu items
    echo '<ul class="bsc__dropdown-menu">';
    foreach ($menu_items as $item) {
        echo '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
    }
    echo '</ul>';
    echo '</li>';
}
?>



<div class="bsc__header--desktop">
    <div class="bsc__header--top">
        <div class="header__container">
            <div class="header__icon">
                <a href="<?php echo home_url(); ?>">
                    <img width="130px" src="<?php echo get_stylesheet_directory_uri(); ?>/components/header/images/logo-BSC.png" alt="BSC Logo">
                </a>
            </div>
            <div class="header__navs">
                <nav class="bsc__menu">
                    <ul class="bsc__nav-links">

                        <li class="bsc__nav-link">
                            <span>SKIN CARE</span>
                            <i aria-hidden="true" class="fas fa-angle-up"></i>
                        </li>

                        <?php 
                            // Render each menu as a dropdown
                            $menu_slugs = [
                                'BSC_MENU_BLOG',
                                'BSC_MENU_COMPLEMENTOS',
                                'BSC_MENU_RUTINA_BASICA',
                                'BSC_MENU_RUTINA_COREANA',
                                'BSC_MENU_RUTINA_EXPERTA',
                                'BSC_MENU_RUTINA_INTERMEDIA'
                            ];

                            foreach ($menu_slugs as $slug) {
                                //render_dropdown_menu($slug);
                            }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="header__menus">
                <i aria-hidden="true" class="dlicon ui-1_zoom"></i>
                <i aria-hidden="true" class="dlicon ui-1_zoom"></i>
                <i aria-hidden="true" class="dlicon shopping_bag-20"></i>
                <i class="eicon-close"></i>
            </div>
        </div>
    </div>
    <div class="bsc__header--bottom">
        <div class="header__container">
        </div>
    </div>
</div>

<?php 

                    