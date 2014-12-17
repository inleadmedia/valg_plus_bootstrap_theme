<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */

// @todo
// Believe all this info should be available in the view object.
$field_info = field_info_field($field->field);

if ($field_info['type'] == 'taxonomy_term_reference') {
  $nid = $row->{$field->field_alias};
  $node = node_load($nid);
  $entity = entity_metadata_wrapper('node', $node);
  $tid = $entity->{$field->field}->value()->tid;
  $term = taxonomy_term_load($tid);
  echo l($term->name, '', array('query' => array($field->field . '_tid[]' => $tid)));
}
else {
  print $output;
}
