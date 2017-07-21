<?php

use smartcat\admin\CheckBoxField;
use smartcat\admin\HTMLFilter;
use smartcat\admin\IntegerValidator;
use smartcat\admin\MatchFilter;
use smartcat\admin\RangeValidator;
use smartcat\admin\SelectBoxField;
use smartcat\admin\SettingsSection;
use smartcat\admin\SettingsTab;
use smartcat\admin\TabbedMenuPage;
use smartcat\admin\TextAreaField;
use smartcat\admin\TextField;
use smartcat\admin\TextFilter;
use ucare\Options;
use ucare\Plugin;

$plugin_url = Plugin::plugin_url( \ucare\PLUGIN_ID );

$appearance = new SettingsSection( 'uc_appearance', __( 'Appearance', 'ucare' ) );

$fonts = \ucare\fonts();

$appearance->add_field( new SelectBoxField(
    array(
        'id'            => 'support_primary_font',
        'option'        => Options::PRIMARY_FONT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::PRIMARY_FONT, \ucare\Defaults::PRIMARY_FONT ),
        'options'       => $fonts,
        'label'         => __( 'Primary Font', 'ucare' ),
        'desc'          => __( 'Headings font for the system', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $fonts ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_secondary_font',
        'option'        => Options::SECONDARY_FONT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::SECONDARY_FONT, \ucare\Defaults::SECONDARY_FONT ),
        'options'       => $fonts,
        'label'         => __( 'Secondary Font', 'ucare' ),
        'desc'          => __( 'Main content / body text font for the system', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $fonts ), '' ) )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_primary_color',
        'option'        => Options::PRIMARY_COLOR,
        'class'         => array( 'regular-text', 'color_picker' ),
        'value'         => get_option( Options::PRIMARY_COLOR, \ucare\Defaults::PRIMARY_COLOR ),
        'label'         => __( 'Primary color', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_hover_color',
        'option'        => Options::HOVER_COLOR,
        'class'         => array( 'regular-text', 'color_picker' ),
        'value'         => get_option( Options::HOVER_COLOR, \ucare\Defaults::HOVER_COLOR ),
        'label'         => __( 'Hover color', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_secondary_color',
        'option'        => Options::SECONDARY_COLOR,
        'value'         => get_option( Options::SECONDARY_COLOR, \ucare\Defaults::SECONDARY_COLOR ),
        'label'         => __( 'Secondary color', 'ucare' ),
        'class'         => array( 'regular-text', 'color_picker' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_tertiary_color',
        'option'        => Options::TERTIARY_COLOR,
        'value'         => get_option( Options::TERTIARY_COLOR, \ucare\Defaults::TERTIARY_COLOR ),
        'label'         => __( 'Tertiary color', 'ucare' ),
        'class'         => array( 'regular-text', 'color_picker' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_login_background_image',
        'class'         => array( 'image-upload' ),
        'option'        => Options::LOGIN_BACKGROUND,
        'value'         => get_option( Options::LOGIN_BACKGROUND, \ucare\Defaults::LOGIN_BACKGROUND ),
        'label'         => __( 'Login Background Image', 'ucare' )
    )

) );

$categories = new SettingsSection( 'uc_categories', __( 'Ticket Categories', 'ucare' ) );

$categories->add_field( new TextField(
    array(
        'id'            => 'support_ticket_categories_name',
        'class'         => array( 'regular-text' ),
        'option'        => Options::CATEGORIES_NAME,
        'value'         => get_option( Options::CATEGORIES_NAME, \ucare\Defaults::CATEGORIES_NAME ),
        'label'         => __( 'Categories Name', 'ucare' ),
        'desc'          => __( 'The name to be used for ticket category', 'ucare' ),
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_ticket_categories_name_plural',
        'class'         => array( 'regular-text' ),
        'option'        => Options::CATEGORIES_NAME_PLURAL,
        'value'         => get_option( Options::CATEGORIES_NAME_PLURAL, \ucare\Defaults::CATEGORIES_NAME_PLURAL ),
        'label'         => __( 'Categories Name Plural', 'ucare' ),
        'desc'          => __( 'The plural name to be used for ticket category', 'ucare' ),
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_categories_enabled',
        'option'        => Options::CATEGORIES_ENABLED,
        'value'         => get_option( Options::CATEGORIES_ENABLED, \ucare\Defaults::CATEGORIES_ENABLED ),
        'label'         => __( 'Categories Enabled', 'ucare'),
        'desc'          => __( 'Allow tickets to be assigned a category when created', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) );

$text = new SettingsSection( 'uc_text', __( 'Text & Labels', 'ucare' ) );

$text->add_field( new TextField(
    array(
        'id'            => 'support_login_disclaimer',
        'option'        => Options::LOGIN_DISCLAIMER,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::LOGIN_DISCLAIMER, \ucare\Defaults::LOGIN_DISCLAIMER ),
        'label'         => __( 'Login Disclaimer', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_register_btn_text',
        'option'        => Options::REGISTER_BTN_TEXT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::REGISTER_BTN_TEXT, \ucare\Defaults::REGISTER_BTN_TEXT ),
        'label'         => __( 'Register Button Label', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_login_btn_text',
        'option'        => Options::LOGIN_BTN_TEXT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::LOGIN_BTN_TEXT, \ucare\Defaults::LOGIN_BTN_TEXT ),
        'label'         => __( 'Login Button Label', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_create_btn_text',
        'option'        => Options::CREATE_BTN_TEXT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::CREATE_BTN_TEXT, \ucare\Defaults::CREATE_BTN_TEXT ),
        'label'         => __( 'Create Ticket Button Label', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_cancel_btn_text',
        'option'        => Options::CANCEL_BTN_TEXT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::CANCEL_BTN_TEXT, \ucare\Defaults::CANCEL_BTN_TEXT ),
        'label'         => __( 'Cancel Operation Button Label', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_ticket_created_msg',
        'option'        => Options::TICKET_CREATED_MSG,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TICKET_CREATED_MSG, \ucare\Defaults::TICKET_CREATED_MSG ),
        'label'         => __( 'Ticket Created Message', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_ticket_updated_msg',
        'option'        => Options::TICKET_UPDATED_MSG,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TICKET_UPDATED_MSG, \ucare\Defaults::TICKET_UPDATED_MSG ),
        'label'         => __( 'Ticket Updated Message', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_empty_table_msg',
        'option'        => Options::EMPTY_TABLE_MSG,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::EMPTY_TABLE_MSG, \ucare\Defaults::EMPTY_TABLE_MSG ),
        'label'         => __( 'No Tickets Message', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'support_comments_closed_msg',
        'option'        => Options::COMMENTS_CLOSED_MSG,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::COMMENTS_CLOSED_MSG, \ucare\Defaults::COMMENTS_CLOSED_MSG ),
        'label'         => __( 'Comments Closed Message', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'support_footer_text',
        'option'        => Options::FOOTER_TEXT,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::FOOTER_TEXT, \ucare\Defaults::FOOTER_TEXT ),
        'label'         => __( 'Footer Text', 'ucare' ),
        'validators'    => array( new TextFilter() )
    )
) );

$widgets = new SettingsSection( 'uc_widgets', __( 'Widgets', 'ucare' ) );

$widgets->add_field( new TextAreaField(
    array(
        'id'            => 'support_login_widget_area',
        'option'        => Options::LOGIN_WIDGET_AREA,
        'class'         => array( 'regular-text' ),
        'props'         => array( 'rows' => array( 5 ) ),
        'value'         => stripcslashes( get_option( Options::LOGIN_WIDGET_AREA, \ucare\Defaults::LOGIN_WIDGET_AREA ) ),
        'label'         => __( 'Login Widget Area', 'ucare' ),
        'desc'          => __( 'Displayed on the login page', 'ucare' ),
        'validators'    => array( new HTMLFilter() )
    )
) )->add_field( new TextAreaField(
    array(
        'id'            => 'support_user_widget_area',
        'option'        => Options::USER_WIDGET_AREA,
        'class'         => array( 'regular-text' ),
        'props'         => array( 'rows' => array( 5 ) ),
        'value'         => stripcslashes( get_option( Options::USER_WIDGET_AREA, \ucare\Defaults::USER_WIDGET_AREA ) ),
        'label'         => __( 'User Widget Area', 'ucare' ),
        'desc'          => __( 'Only visible to support users', 'ucare' ),
        'validators'    => array( new HTMLFilter() )
    )
) )->add_field( new TextAreaField(
    array(
        'id'            => 'support_agent_widget_area',
        'option'        => Options::AGENT_WIDGET_AREA,
        'class'         => array( 'regular-text' ),
        'props'         => array( 'rows' => array( 5 ) ),
        'value'         => stripcslashes( get_option( Options::AGENT_WIDGET_AREA, \ucare\Defaults::AGENT_WIDGET_AREA ) ),
        'label'         => __( 'Agent Widget Area', 'ucare' ),
        'desc'          => __( 'Only visible to support agents and admins', 'ucare' ),
        'validators'    => array( new HTMLFilter() )
    )
) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_categories_enabled',
        'option'        => Options::QUICK_LINK_ENABLED,
        'value'         => get_option( Options::QUICK_LINK_ENABLED, \ucare\Defaults::QUICK_LINK_ENABLED ),
        'label'         => __( 'Quick Link Enabled', 'ucare'),
        'desc'          => __( 'Display support quick link widget on your site', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_quick_link_label',
        'class'         => array( 'regular-text' ),
        'option'        => Options::QUICK_LINK_LABEL,
        'value'         => get_option( Options::QUICK_LINK_LABEL, \ucare\Defaults::QUICK_LINK_LABEL ),
        'label'         => __( 'Quick Link Label', 'ucare' ),
        'desc'          => __( 'Label to be displayed on the quick link widget', 'ucare' ),
    )

) );

$general = new SettingsSection( 'uc_general', __( 'General Settings', 'ucare' ) );

$general->add_field( new TextField(
    array(
        'id'            => 'support_logo_image',
        'class'         => array( 'image-upload' ),
        'option'        => Options::LOGO,
        'value'         => get_option( Options::LOGO, $plugin_url . 'assets/images/logo.png' ),
        'label'         => __( 'Logo Image', 'ucare' )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_favicon',
        'class'         => array( 'image-upload' ),
        'option'        => Options::FAVICON,
        'value'         => get_option( Options::FAVICON, $plugin_url . 'assets/images/favicon.png' ),
        'label'         => __( 'Favicon', 'ucare' )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_company_name',
        'option'        => Options::COMPANY_NAME,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::COMPANY_NAME, \ucare\Defaults::COMPANY_NAME ),
        'label'         => __( 'Company Name', 'ucare' )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_terms_url',
        'type'          => 'url',
        'option'        => Options::TERMS_URL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TERMS_URL, home_url() ),
        'label'         => __( 'Terms & Conditions URL', 'ucare' ),
        'desc'          => __( 'URL of page containing your terms and conditions', 'ucare' )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_allow_signups',
        'option'        => Options::ALLOW_SIGNUPS,
        'value'         => get_option( Options::ALLOW_SIGNUPS, \ucare\Defaults::ALLOW_SIGNUPS ),
        'label'         => __( 'Allow users to signup', 'ucare' ),
        'desc'          => __( 'Allow users to create accounts for submitting tickets', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_ecommerce_integration',
        'option'        => Options::ECOMMERCE,
        'value'         => get_option( Options::ECOMMERCE, \ucare\Defaults::ECOMMERCE ),
        'label'         => __( 'E-Commerce Integration', 'ucare' ),
        'desc'          => __( 'Enable integration with Easy Digital Downloads or WooCommerce', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_tickets_per_page',
        'type'          => 'number',
        'option'        => Options::MAX_TICKETS,
        'value'         => get_option( Options::MAX_TICKETS, \ucare\Defaults::MAX_TICKETS ),
        'label'         => __( 'Tickets Per Page', 'ucare' ),
        'desc'          => __( 'The maximum number of tickets to be loaded per page', 'ucare' ),
        'validators'    => array( new IntegerValidator() )
    )
) )->add_field( new TextField(
    array(
        'id'            => 'support_max_attachment_size',
        'type'          => 'number',
        'option'        => Options::MAX_ATTACHMENT_SIZE,
        'value'         => get_option( Options::MAX_ATTACHMENT_SIZE, \ucare\Defaults::MAX_ATTACHMENT_SIZE ),
        'label'         => __( 'Maximum attachment size', 'ucare' ),
        'desc'          => __( 'The maximum file size for attachments in MB', 'ucare' ),
        'validators'    => array( new IntegerValidator() )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_refresh_time',
        'type'          => 'number',
        'option'        => Options::REFRESH_INTERVAL,
        'value'         => get_option( Options::REFRESH_INTERVAL, \ucare\Defaults::REFRESH_INTERVAL ),
        'label'         => __( 'List Refresh Interval', 'ucare' ),
        'desc'          => __( 'Automatic refresh interval in seconds', 'ucare' ),
        'validators'    => array( new IntegerValidator() )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_logging_enabled',
        'option'        => Options::LOGGING_ENABLED,
        'value'         => get_option( Options::LOGGING_ENABLED, \ucare\Defaults::LOGGING_ENABLED ),
        'label'         => __( 'Enable Logging', 'ucare' ),
        'desc'          => __( 'Enable or disable the logging of system events', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) );


$auto_close = new SettingsSection( 'uc_auto_close', __( 'Inactive Tickets', 'ucare' ) );

$auto_close_interval = get_option( Options::INACTIVE_MAX_AGE, \ucare\Defaults::INACTIVE_MAX_AGE );

$auto_close->add_field( new TextField(
    array(
        'id'            => 'support_autoclose_max-age',
        'type'          => 'number',
        'option'        => Options::INACTIVE_MAX_AGE,
        'value'         => $auto_close_interval,
        'label'         => __( 'Max Ticket Age', 'ucare' ),
        'desc'          => __( 'The maximum number of days of inactivity for a ticket', 'ucare' ),
        'props'         => array( 'max' => array( 356 ),'min' => array( 1 ) ),
        'validators'    => array( new IntegerValidator(), new RangeValidator( 1, 365, $auto_close_interval ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_autoclose_enabled',
        'option'        => Options::AUTO_CLOSE,
        'value'         => get_option( Options::AUTO_CLOSE, \ucare\Defaults::AUTO_CLOSE ),
        'label'         => __( 'Auto Close Tickets', 'ucare' ),
        'desc'          => __( 'Automatically close tickets after they become inactive', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) );

$emails = new SettingsSection( 'uc_email_templates', __( 'User Notification Templates', 'ucare' ) );

$email_templates = array( '' => __( 'Notifications Disabled', 'ucare' ) ) + \smartcat\mail\list_templates();

$emails->add_field( new SelectBoxField(
    array(
        'id'            => 'support_welcome_email_template',
        'option'        => Options::WELCOME_EMAIL_TEMPLATE,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::WELCOME_EMAIL_TEMPLATE ),
        'options'       => $email_templates,
        'label'         => __( 'Welcome', 'ucare' ),
        'desc'          => __( 'Sent when a user registers for the first time', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_ticket_closed_email_template',
        'option'        => Options::TICKET_CLOSED_EMAIL_TEMPLATE,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TICKET_CLOSED_EMAIL_TEMPLATE ),
        'options'       => $email_templates,
        'label'         => __( 'Ticket Closed', 'ucare' ),
        'desc'          => __( 'Sent when the ticket is marked as closed', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_ticket_created_email_template',
        'option'        => Options::TICKET_CREATED_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TICKET_CREATED_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'Ticket Created', 'ucare' ),
        'desc'          => __( 'Sent when a user creates a new ticket', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_reply_email_template',
        'option'        => Options::AGENT_REPLY_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::AGENT_REPLY_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'Agent Reply', 'ucare' ),
        'desc'          => __( 'Sent when an agent replies to a ticket', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_pw_reset_email_template',
        'option'        => Options::PASSWORD_RESET_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::PASSWORD_RESET_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'Forgot Password Reset', 'ucare' ),
        'desc'          => __( 'Sent when a user forgets their password', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_autoclose_email_template',
        'option'        => Options::INACTIVE_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::INACTIVE_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'Automatic Close Warning', 'ucare' ),
        'desc'          => __( 'Sent out to warn users of automatic ticket closure', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) );

$admin_emails = new SettingsSection( 'uc_admin_email_notifications', __( 'Admin Notification Templates', 'ucare' ) );

$admin_emails->add_field( new SelectBoxField(
    array(
        'id'            => 'support_ticket_created_admin_email_template',
        'option'        => Options::NEW_TICKET_ADMIN_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::NEW_TICKET_ADMIN_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'New Ticket', 'ucare' ),
        'desc'          => __( 'Sent to the admin user when a user creates a new ticket', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) );

$agent_emails = new SettingsSection( 'uc_agent_email_notifications', __( 'Agent Notification Templates', 'ucare' ) );

$agent_emails->add_field( new SelectBoxField(
    array(
        'id'            => 'support_customer_reply_email_template',
        'option'        => Options::CUSTOMER_REPLY_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::CUSTOMER_REPLY_EMAIL ),
        'options'       => $email_templates,
        'label'         => __( 'Customer Reply', 'ucare' ),
        'desc'          => __( 'Sent out to support agents when a customer replies to a ticket they\'re assigned to', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) )->add_field( new SelectBoxField(
    array(
        'id'            => 'support_ticket_assigned_email_template',
        'option'        => Options::TICKET_ASSIGNED,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::TICKET_ASSIGNED ),
        'options'       => $email_templates,
        'label'         => __( 'Ticket Assigned', 'ucare' ),
        'desc'          => __( 'Sent out to support agents when they are assigned a ticket', 'ucare' ),
        'validators'    => array( new MatchFilter( array_keys( $email_templates ), '' ) )
    )

) );

$email_notifications = new SettingsSection( 'uc_email_notifications', __( 'Email Notifications', 'ucare' ) );

$email_notifications->add_field( new CheckBoxField(
    array(
        'id'            => 'support_email_notifications',
        'option'        => Options::EMAIL_NOTIFICATIONS,
        'value'         => get_option( Options::EMAIL_NOTIFICATIONS, \ucare\Defaults::EMAIL_NOTIFICATIONS ),
        'label'         => __( 'Email Notifications', 'ucare' ),
        'desc'          => __( 'Send out automated email notifications in response to ticket events', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_email_recipient_email',
        'option'        => Options::ADMIN_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::ADMIN_EMAIL, get_option( 'admin_email' ) ),
        'label'         => __( 'Admin Email', 'ucare' ),
        'desc'          => __( 'Email address of the support administrator', 'ucare' )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_email_sender_email',
        'option'        => Options::SENDER_EMAIL,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::SENDER_EMAIL, get_option( 'admin_email' ) ),
        'label'         => __( 'Sender Email', 'ucare' ),
        'desc'          => __( 'Email address used when sending support emails', 'ucare' )
    )

) )->add_field( new TextField(
    array(
        'id'            => 'support_email_sender_name',
        'option'        => Options::SENDER_NAME,
        'class'         => array( 'regular-text' ),
        'value'         => get_option( Options::SENDER_NAME, __( 'uCare Support', 'ucare' ) ),
        'label'         => __( 'Sender Name', 'ucare' ),
        'desc'          => __( 'Name used for outgoing support emails', 'ucare' )
    )

) );

$advanced = new SettingsSection( 'uc_advanced', __( 'CAUTION: Some of these may bite', 'ucare' ) );

$advanced->add_field( new CheckBoxField(
    array(
        'id'            => 'support_enable_dev_mode',
        'option'        => Options::DEV_MODE,
        'value'         => get_option( Options::DEV_MODE, \ucare\Defaults::DEV_MODE ),
        'label'         => __( 'Developer Mode', 'ucare' ),
        'desc'          => __( 'Enable development functionality', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_nuke_data',
        'option'        => Options::NUKE,
        'value'         => get_option( Options::NUKE, \ucare\Defaults::NUKE ),
        'label'         => __( 'Erase All Data', 'ucare'),
        'desc'          => __( 'Erase all data on plugin deactivation if developer mode is enabled', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) )->add_field( new CheckBoxField(
    array(
        'id'            => 'support_restore_template',
        'option'        => Options::RESTORE_TEMPLATE,
        'value'         => '',
        'label'         => __( 'Restore Template Page', 'ucare' ),
        'desc'          => __( 'Restore the template page if its been deleted', 'ucare' ),
        'validators'    => array( new MatchFilter( array( '', 'on' ), '' ) )
    )

) );

$admin = new TabbedMenuPage(
    array(
        'type'          => 'submenu',
        'parent_menu'   => 'ucare_support',
        'menu_title'    => __( 'Settings', 'ucare' ),
        'menu_slug'     => 'uc-settings',
        'tabs'          => array(
            new SettingsTab(
                array(
                    'slug'     => 'uc-general',
                    'title'    => __( 'General', 'ucare' ),
                    'sections' => array( $general, $auto_close )
                )
            ),
            new SettingsTab(
                array(
                    'slug'     => 'uc-display',
                    'title'    => __( 'Display', 'ucare' ),
                    'sections' => array( $categories, $text, $widgets )
                )
            ),
            new SettingsTab(
                array(
                    'slug'     => 'uc-appearance',
                    'title'    => __( 'Appearance', 'ucare' ),
                    'sections' => array( $appearance )
                )
            ),
            new SettingsTab(
                array(
                    'slug'     => 'uc-email',
                    'title'    => __( 'Email', 'ucare' ),
                    'sections' => array( $emails, $agent_emails, $admin_emails, $email_notifications )
                )
            ),
            new SettingsTab(
                array(
                    'slug'     => 'uc-advanced',
                    'title'    => __( 'Advanced', 'ucare' ),
                    'sections' => array( $advanced )
                )
            )
        )
    )
);

return $admin;
