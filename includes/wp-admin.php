<?php

namespace ucare;


function enqueue_admin_scripts($hook ) {

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    wp_enqueue_script( 'wp_media_uploader',
        plugin_url( 'assets/lib/wp_media_uploader.js' ), array( 'jquery' ), PLUGIN_VERSION );

    wp_enqueue_style( 'support-admin-icons',
        plugin_url( '/assets/icons/style.css' ), null, PLUGIN_VERSION );

    wp_register_script('support-admin-js',
        plugin_url( 'assets/admin/admin.js' ), array( 'jquery' ), PLUGIN_VERSION );

    wp_localize_script( 'support-admin-js',
        'SupportSystem', array(
            'ajax_url'   => admin_url( 'admin-ajax.php' ),
            'ajax_nonce' => wp_create_nonce( 'support_ajax' )
        )
    );

    wp_enqueue_media();
    wp_enqueue_script( 'support-admin-js' );

    wp_enqueue_style( 'support-admin-css',
        plugin_url( '/assets/admin/admin.css' ), null, PLUGIN_VERSION );

    if( strpos( $hook, 'ucare' ) !== false ) {

        wp_enqueue_script( 'moment',
            plugin_url( '/assets/lib/moment/moment.min.js' ), null, PLUGIN_VERSION );

        wp_enqueue_script( 'flot',
            plugin_url( '/assets/lib/flot/jquery.flot.min.js' ), null, PLUGIN_VERSION );

        wp_enqueue_script( 'flot-time',
            plugin_url( '/assets/lib/flot/jquery.flot.time.min.js' ), null, PLUGIN_VERSION );

        wp_enqueue_script( 'flot-resize',
            plugin_url( '/assets/lib/flot/jquery.flot.resize.min.js' ), null, PLUGIN_VERSION );

        wp_enqueue_script( 'moment',
            plugin_url( '/assets/lib/moment/moment.min.js' ), null, PLUGIN_VERSION );

        wp_enqueue_script( 'ucare-reports-js',
            plugin_url( '/assets/admin/reports.js' ), null, PLUGIN_VERSION );

        wp_enqueue_style( 'ucare-reports-css',
            plugin_url( '/assets/admin/reports.css' ), null, PLUGIN_VERSION );

    }

}

add_action( 'admin_enqueue_scripts', 'ucare\enqueue_admin_scripts' );


function admin_page_header() {
    include_once plugin_dir() . '/templates/admin-header.php';
}

// Include admin header
add_action( 'uc-settings_admin_page_header', 'ucare\admin_page_header' );


function admin_page_sidebar() {
    include_once plugin_dir() . '/templates/admin-sidebar.php';
}

// Include admin sidebar on options page
add_action( 'uc-settings_menu_page', 'ucare\admin_page_sidebar' );


function add_admin_menu_pages() {

    add_submenu_page( null, __( 'uCare - Introduction', 'ucare' ), __( 'uCare - Introduction', 'ucare' ), 'manage_options', 'uc-tutorial', function() { include_once plugin_dir() . 'templates/admin-tutorial.php'; } );

}

add_action( 'admin_menu', 'ucare\add_admin_menu_pages' );


function admin_first_run_tutorial_page() {

    if( !get_option( Options::FIRST_RUN ) ) {

        update_option( Options::FIRST_RUN, true );
        wp_safe_redirect( admin_url( 'admin.php?page=uc-tutorial' ) );

    }

}

add_action( 'admin_init', 'ucare\admin_first_run_tutorial_page' );


function admin_bar_ticket_count( \WP_Admin_Bar $admin_bar ) {

    if( current_user_can( 'manage_support' ) ) {

        $count = statprocs\get_unclosed_tickets();

        $item = array(
            'id' => 'ucare_admin_ticket_count',
            'title' => '<span class="ab-icon dashicons dashicons-sos" style="margin-top: 2px;"></span>
                        <span class="ab-label">' . $count . ' </span>',
            'href' => support_page_url()
        );

        $admin_bar->add_node($item);

    }

}

add_action( 'admin_bar_menu', 'ucare\admin_bar_ticket_count', 80 );


function add_plugin_action_links( $links ) {

    if( get_option( Options::DEV_MODE ) !== 'on' ) {
        $links['deactivate'] = '<span id="feedback-prompt">' . $links['deactivate'] . '</span>';
    }

    $menu_page = menu_page_url( 'uc-settings', false );

    return array_merge( array( 'settings' => '<a href="' . $menu_page . '">' . __( 'Settings', 'ucare' ) . '</a>' ), $links );
}

add_action( 'plugin_action_links_' . basename(), 'ucare\add_plugin_action_links' );