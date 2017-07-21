<?php

use ucare\Plugin;

$form = include Plugin::plugin_dir( \ucare\PLUGIN_ID ) . '/config/ticket_create_form.php';

?>

<div id="create_ticket" class="form-wrapper">

    <form id="create-ticket-form">

        <?php foreach( $form->fields as $name => $field ) : ?>

            <div class="form-group">

                <label for="<?php echo $field->id; ?>"><?php echo $field->label; ?></label>

                <?php $field->render(); ?>

            </div>

        <?php endforeach; ?>

        <input type="hidden" class="attachments" name="attachments" value="[]" data-default="[]" />
        <input type="hidden" name="<?php echo $form->id; ?>" />

    </form>

    <div class="form-group">

        <label><?php _e( 'Attach Images', 'ucare' ); ?></label>

        <form id="ticket-media-upload" class="dropzone">

            <?php wp_nonce_field( 'support_ajax', '_ajax_nonce' ); ?>

        </form>

    </div>

</div>
