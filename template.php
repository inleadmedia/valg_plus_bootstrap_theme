<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_form_alter().
 */
function valg_plus_bootstrap_theme_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'views_exposed_form' && isset($form['field_bkm_list_tid'])) {
    // Sort the dropdown in a descending order.
    $options = $form['field_bkm_list_tid']['#options'];
    arsort($options, SORT_NATURAL);
    $form['field_bkm_list_tid']['#options'] = $options;
  }
}
