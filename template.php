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
    arsort($options);
    $form['field_bkm_list_tid']['#options'] = $options;
  }
}

/**
 * Implementation of template preprocess for the view fields.
 */
function valg_plus_bootstrap_theme_preprocess_views_bootstrap_thumbnail_plugin_rows(&$vars) {
  $view = &$vars['view'];

  switch ($view->name) {
    case 'bkm_item_list':
      $current_display = $view->current_display;
      if ($view->current_display == 'panel_pane_gallery_list') {
        foreach (array('image', 'title') as $key) {
          $vars[$key] = l($vars[$key], 'valg/bkm/popup/' . $vars['row']->nid, array(
            'attributes' => array(
              'data-toggle' => 'modal',
              'data-target' => '#bkm-item-gallery-popup-' . $vars['row']->nid,
            ),
            'html' => TRUE,
          ));
        }
      }
      break;
  }
}

/**
 * Preprocessw function to views.tpl.php.
 */
function valg_plus_bootstrap_theme_preprocess_views_view(&$vars) {
  global $pager_page_array;

  $view = &$vars['view'];
  switch ($view->name) {
    case 'bkm_item_list':
      if ($view->current_display == 'panel_pane_gallery_list') {
        $current_display = $view->display[$view->current_display];
        $pager_id = $current_display->display_options['pager']['options']['id'];
        $current_page = $pager_page_array[$pager_id];
        $nids = array();
        foreach ($view->result as $row) {
          $nids[] = $row->nid;
        }

        // Store nids of the BKM List items to the cache (static or database's
        // cache) to use them later.
        if ($current_display->display_options['cache']['type'] == 'none') {
          $cache = &drupal_static('_vagl_gallery_list_nids');
          $cache = $nids;
        }
        else {
          $cache = cache_get('_vagl_gallery_list_nids');
          $cache = !empty($cache->data) ? $cache->data : array();
          $cache['pager_id'] = $pager_id;
          $cache[$current_page] = $nids;
          cache_set('_vagl_gallery_list_nids', $cache);
        }
      }
      break;
  }
}

/**
 * Duplication of a part of the template_preprocess_views_view_fields to
 * implement displaying of the field-label.
 *
 * @see template_preprocess_views_view_fields()
 */
function valg_plus_bootstrap_theme_preprocess_views_view_field(&$vars) {
  $view = $vars['view'];
  $field = $vars['field'];

  switch ($view->name) {
    case 'bkm_item_list':
      if ($view->current_display == 'panel_pane_1') {
        $id = $field->options['id'];
        if (!empty($view->style_options['info'][$id]['show_title'])) {
          $vars['label'] = check_plain($field->label());
          $vars['label_html'] = '';
          if ($vars['label']) {
            $vars['label_html'] .= $vars['label'];
            if ($field->options['element_label_colon']) {
              $vars['label_html'] .= ': ';
            }

            $default_classes = !empty($field->options['element_default_classes']) ? $field->options['element_default_classes'] : FALSE;
            $vars['element_label_type'] = $field->element_label_type(TRUE, !$default_classes);
            if ($vars['element_label_type']) {
              $class = '';
              $field_class = drupal_clean_css_identifier($id);
              if ($default_classes) {
                $class = 'views-label views-label-' . $field_class;
              }

              $element_label_class = $field->element_label_classes($view->row_index);
              if ($element_label_class) {
                if ($class) {
                  $class .= ' ';
                }

                $class .= $element_label_class;
              }

              $pre = '<' . $vars['element_label_type'];
              if ($class) {
                $pre .= ' class="' . $class . '"';
              }
              $pre .= '>';

              $vars['label_html'] = $pre . $vars['label_html'] . '</' . $vars['element_label_type'] . '>';
            }
          }
        }
      }
      break;
  }
}

/**
 * Preprocess to page.tpl.php.
 */
function valg_plus_bootstrap_theme_preprocess_page(&$vars) {
  global $pager_page_array;

  // Get nids to output mockup popups.
  $cache = drupal_static('_vagl_gallery_list_nids');
  if (empty($cache)) {
    $cache = cache_get('_vagl_gallery_list_nids');
    $cache = !empty($cache->data) ? $cache->data : array();
    $current_page = $pager_page_array[$cache['pager_id']];
    $cache = isset($cache[$current_page]) ? $cache[$current_page] : array();
  }

  // Loop through node ids and output mockup popups.
  foreach ($cache as $nid) {
    $popup = array(
      'heading' => t('Details'),
      'body' => '',
      'footer' => '',
      'attributes' => array(
        'id' => 'bkm-item-gallery-popup-' . $nid,
      ),
      'html_heading' => FALSE,
    );
    if (!isset($vars['page']['content']['system_main']['content']['#markup'])) {
      $vars['page']['content']['system_main']['main']['#markup'] .= theme('bootstrap_modal', $popup);
    }
    else {
      $vars['page']['content']['system_main']['content']['#markup'] .= theme('bootstrap_modal', $popup);
    }
  }
}

/**
 * Preprocess to bootstrap-modal.tpl.php.
 */
function valg_plus_bootstrap_theme_process_bootstrap_modal(&$variables) {
  if ($key = array_search('fade', $variables['attributes']['class'])) {
    unset($variables['attributes']['class'][$key]);
  }
}
