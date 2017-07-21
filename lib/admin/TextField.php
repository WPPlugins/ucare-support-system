<?php

namespace smartcat\admin;

if( !class_exists( '\smartcat\admin\TextField' ) ) :

class TextField extends SettingsField {
    protected $type = 'text';

    public function __construct( array $args ) {
        parent::__construct( $args );

        if( !empty( $args['type'] ) ) {
            $this->type = $args['type'];
        }
    }

    public function render( array $args ) { ?>

        <input id="<?php esc_attr_e( $this->id ); ?>"
            name="<?php esc_attr_e( $this->option ); ?>"
            type="<?php esc_attr_e( $this->type ); ?>"
            value="<?php esc_attr_e( $this->value ); ?>"

            <?php $this->props(); ?>
            <?php $this->classes(); ?> />

        <?php if( !empty( $this->desc ) ) : ?>

            <p class="description"><?php echo $this->desc; ?></p>

        <?php endif; ?>

    <?php }
}

endif;