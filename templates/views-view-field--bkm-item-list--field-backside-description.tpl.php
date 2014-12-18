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
?>
<?php
global $user;
$allowed_roles = array(
  'administrator',
  'moderator',
);

if ($view->current_display == 'panel_pane_1' && array_intersect($allowed_roles, $user->roles)) {
  print $output;
}
elseif($view->current_display != 'panel_pane_1') {
  $empty_prefix = '<div class="panel-body alert-warning">';
  $empty_suffix = '</div>';
  $empty_text = '<strong>Sorry!</strong> No backside description available.';
  $output_prefix = '<div class="panel-body">';
  $output_suffix = '</div>';

  $editable_fields = variable_get('valg_quickedit_enabled_fields', array());

  if (array_key_exists($field->field, $editable_fields)) {
    $editable_prefix = '<span class="' . $editable_fields[$field->field] . '" data-pk="' . $row->nid . '" data-name="' . $field->field . '" data-type="textarea">';
    $editable_suffix = '</span>';
    if (empty($output)) {
      print $empty_prefix . $editable_prefix . $empty_text . $editable_suffix . $empty_suffix;
    }
    else {
      print $output_prefix .
        '<div class="' . $editable_fields[$field->field] . '" data-pk="' . $row->nid . '" data-name="' . $field->field . '" data-type="textarea">' . $output . '</div>' .
        $output_suffix;
    }
  }
  else {
    if (empty($output)) {
      print $empty_prefix . $empty_text . $empty_suffix;
    }
    else {
      print $output_prefix . '<p>' . $output . '</p>' . $output_suffix;
    }
  }

}
?>
