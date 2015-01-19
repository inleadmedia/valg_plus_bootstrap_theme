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
global $user;
$allowed_roles = array('administrator', 'moderator');
$field_info = field_info_field($field->field);
$editable_fields = variable_get('valg_quickedit_enabled_fields', array());

if (array_key_exists($field->field, $editable_fields) && !empty(array_intersect($user->roles, $allowed_roles))) {
  $title_attr = 'data-title="' . $field->definition['title'] . '"';
  $taxonomy_fields = variable_get('valg_quickedit_taxonomy_fields', array());
  $data_type = (!empty($taxonomy_fields) && in_array($field->field, $taxonomy_fields)) ? 'select2' : 'text';
  if ($field->field == 'field_publication_date') {
    $title_attr = 'data-title="E.g. 01/25/2014"';
  }

  $output = '<span class="' . $editable_fields[$field->field] . '" data-pk="' . $row->nid . '" data-name="' . $field->field . '" data-type="' . $data_type . '"' . $title_attr . '>' . $output . '</span>';
}
elseif ($field_info['type'] == 'taxonomy_term_reference') {
  $nid = $row->{$field->field_alias};
  $node = node_load($nid);
  if (is_object($node)) {
    $entity = entity_metadata_wrapper('node', $node);
    $ent_value = $entity->{$field->field}->value();

    if (!is_array($ent_value)) {
      $ent_value = array($ent_value);
    }

    foreach ($ent_value as $value) {
      if (isset($value->tid)) {
        $tid = $value->tid;
        $term = taxonomy_term_load($tid);
        // @todo
        // Not the best way to translate field values though.
        $raw_output[] = l(t($term->name), '', array('query' => array($field->field . '_tid[]' => $tid)));
      }
    }

    if (isset($raw_output)) {
      $output = implode(', ', $raw_output);
    }
  }
}

if (!empty($field->original_value)) {
  if (!empty($label_html)) {
    print $label_html;
  }
  print $output;
}
