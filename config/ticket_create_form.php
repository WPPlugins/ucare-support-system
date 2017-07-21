<?php

use smartcat\form\ChoiceConstraint;
use smartcat\form\Form;
use smartcat\form\RequiredConstraint;
use smartcat\form\SelectBoxField;
use smartcat\form\TextAreaField;
use smartcat\form\TextBoxField;
use ucare\Options;

$products = \ucare\util\products();

$products = array( 0 => __( 'Select a Product', 'ucare' ) ) + $products;

$form = new Form( 'create_ticket' );

if( get_option( Options::CATEGORIES_ENABLED, \ucare\Defaults::CATEGORIES_ENABLED ) == 'on' ) {

    $terms = get_terms( array( 'taxonomy' => 'ticket_category', 'hide_empty' => false ) );

    if( !empty( $terms ) ) {

        $categories = array();
        $name = get_option( Options::CATEGORIES_NAME, \ucare\Defaults::CATEGORIES_NAME );

        foreach( $terms as $term ) {
            $categories[ $term->name ] = $term->name;
        }

        $form->add_field( new SelectBoxField(
            array(
                'name'          => 'category',
                'class'         => array( 'form-control' ),
                'label'         => __( ucwords( $name ), 'ucare' ),
                'error_msg'     => __( "Please select a $name", 'ucare' ),
                'options'       => array( 0 => __( "Select a $name", 'ucare' ) ) + $categories,
                'props'         => array(
                    'data-default' => array( 0 )
                ),
                'constraints'   => array(
                    new ChoiceConstraint( array_keys( $categories ) )
                )
            )

        ) );

    }

}


if( \ucare\util\ecommerce_enabled() ) {

    $form->add_field( new SelectBoxField(
        array(
            'name'          => 'product',
            'class'         => array( 'form-control' ),
            'label'         => __( 'Product', 'ucare' ),
            'error_msg'     => __( 'Please Select a product', 'ucare' ),
            'options'       => $products,
            'props'         => array(
                'data-default' => array( 0 )
            ),
            'constraints'   => array(
                new ChoiceConstraint( array_keys( $products ) )
            )
        )

    ) )->add_field( new TextBoxField(
        array(
            'name'              => 'receipt_id',
            'class'             => array( 'form-control' ),
            'label'             => __( 'Receipt #', 'ucare' ),
            'sanitize_callback' => 'sanitize_text_field',
            'props'             => array(
                'data-default' => array( '' )
            ),
        )

    ) );
}

$form->add_field( new TextBoxField(
    array(
        'name'          => 'subject',
        'class'         => array( 'form-control' ),
        'label'         => __( 'Subject', 'ucare' ),
        'error_msg'     => __( 'Cannot be blank', 'ucare' ),
        'sanitize_callback' => 'sanitize_text_field',
        'props'         => array(
            'data-default' => array( '' )
        ),
        'constraints'   => array(
            new RequiredConstraint()
        )
    )

) )->add_field( new TextBoxField(
    array(
        'name'          => 'subject',
        'class'         => array( 'form-control' ),
        'label'         => __( 'Subject', 'ucare' ),
        'error_msg'     => __( 'Subject cannot be blank', 'ucare' ),
        'sanitize_callback' => 'sanitize_text_field',
        'props'         => array(
            'data-default' => array( '' )
        ),
        'constraints'   => array(
            new RequiredConstraint()
        )
    )

) )->add_field( new TextAreaField(
    array(
        'name'          => 'description',
        'props'         => array( 'rows' => array( 8 ), 'data-default' => array( '' ) ),
        'class'         => array( 'form-control' ),
        'label'         => __( 'Description', 'ucare' ),
        'error_msg'     => __( 'Description cannot be blank', 'ucare' ),
        'constraints'   => array(
            new RequiredConstraint()
        )
    )

) );

return $form;
