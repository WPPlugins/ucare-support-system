<?php

namespace smartcat\mail;

use smartcat\post\AbstractMetaBox;

class TemplateStyleMetaBox extends AbstractMetaBox {

    public function __construct() {
        parent::__construct( array(
            'id'        => 'mailer_meta',
            'title'     => __( 'Template Style Sheet' ),
            'post_type' => 'email_template',
            'context'   => 'advanced',
            'priority'  => 'high'
        ) );
    }

    public function render( \WP_Post $post ) { ?>

        <textarea rows="25" style="width: 100%" name="template_styles"><?php echo get_post_meta( $post->ID, 'styles', true ); ?></textarea>

    <?php }

    public function save( $post_id, \WP_Post $post ) {
        if( isset( $_POST['template_styles'] ) ) {
            update_post_meta( $post_id, 'styles', wp_strip_all_tags( $_POST['template_styles'] ) );
        }
    }
}
