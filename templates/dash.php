<?php

use ucare\Options;

?>

<div id="support-dashboard-page">

    <div id="settings-modal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title"><?php _e( 'Settings', 'ucare' ); ?></h4>

                </div>

                <div class="message"></div>

                <div class="modal-body">

                    <?php include_once 'settings.php'; ?>

                </div>

                <div class="modal-footer">

                    <button id="save-settings" type="button" class="button button-submit">

                        <span class="glyphicon glyphicon-floppy-save button-icon"></span>

                        <span><?php _e( get_option( Options::SAVE_BTN_TEXT, \ucare\Defaults::SAVE_BTN_TEXT ) ); ?></span>

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div id="create-modal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title"><?php _e( 'New Support Request', 'ucare' ); ?></h4>

                </div>

                <div class="modal-body">

                    <?php include_once 'create_ticket.php'; ?>

                </div>

                <div class="modal-footer">

                    <button id="create-ticket" type="button" class="button button-submit">

                        <?php _e( get_option( Options::CREATE_BTN_TEXT, \ucare\Defaults::CREATE_BTN_TEXT ) ); ?>

                    </button>

                </div>

            </div>

        </div>

    </div>
    
    <div class="container-fluid">

        <?php $widget = current_user_can( 'manage_support_tickets' )
                ? stripslashes( get_option( Options::AGENT_WIDGET_AREA, \ucare\Defaults::AGENT_WIDGET_AREA ) )
                : stripslashes( get_option( Options::USER_WIDGET_AREA, \ucare\Defaults::USER_WIDGET_AREA ) ); ?>

        <?php if( !empty( $widget ) ) : ?>

            <div class="row widget-wrapper">
                <div class="col-sm-12">
                    <?php echo $widget; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if( current_user_can( 'manage_support_tickets' ) ) : ?>
        <div class="row statistics-wrapper">
            <div id="statistics-container"></div>            
        </div>
        <?php endif; ?>
        
        <div class="row ticket-area-wrapper">
            
            <div class="text-right">

                <div class="clear"></div>

            </div>

            <div id="tabs">

                <ul class="nav nav-tabs ticket-nav-tabs">

                    <li class="tab active">
                        <a data-toggle="tab" href="#tickets"><?php _e( 'Tickets', 'ucare' ); ?></a>
                    </li>

                </ul>

                <div class="tab-content ticket-tab-panels">

                    <div id="tickets" class="tab-pane fade in active">

                        <?php include_once 'ticket_filter.php'; ?>

                        <div id="tickets-container" class="row"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
