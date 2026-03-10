<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Register ACF field group for MCQ Details
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_mcq_details',
        'title' => 'MCQ Details',
        'fields' => array(
            array(
                'key' => 'field_mcq_question',
                'label' => 'Question',
                'name' => 'mcq_question',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_option_a',
                'label' => 'Option A',
                'name' => 'mcq_option_a',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_option_b',
                'label' => 'Option B',
                'name' => 'mcq_option_b',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_option_c',
                'label' => 'Option C',
                'name' => 'mcq_option_c',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_option_d',
                'label' => 'Option D',
                'name' => 'mcq_option_d',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_correct_option',
                'label' => 'Correct Option',
                'name' => 'mcq_correct_option',
                'type' => 'select',
                'choices' => array(
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                ),
                'required' => 1,
            ),
            array(
                'key' => 'field_mcq_explanation',
                'label' => 'Explanation',
                'name' => 'mcq_explanation',
                'type' => 'wysiwyg',
                'required' => 0,
            ),
            array(
                'key' => 'field_mcq_difficulty',
                'label' => 'Difficulty Level',
                'name' => 'mcq_difficulty',
                'type' => 'select',
                'choices' => array(
                    'easy' => 'Easy',
                    'medium' => 'Medium',
                    'hard' => 'Hard',
                ),
                'default_value' => 'medium',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'mcqs',
                ),
                array(
                    'param' => 'post_category',
                    'operator' => '==',
                    'value' => get_cat_ID('MCQs'),
                ),
            ),
        ),
    ));
}