<?php

/**
 * Implements hook_panels_layouts().
 */
// Plugin definition
$plugin = array(
  'title' => t('Two Columns 3-9'),
  'category' => t('Bootstrap'),
  'icon' => 'bootstrap_twocol_3_9.png',
  'theme' => 'bootstrap_twocol_3_9',
  'admin css' => 'bootstrap-twocol-3-9.css',
  'regions' => array(
    'left' => t('Left'),
    'right' => t('Right'),
  ),
);
