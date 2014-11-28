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

$rating = $row->field_data_field_rating_field_rating_value;

// Class definitions.
switch ($rating) {
  case '1':
    $class = 'success';
    break;
  case '2':
    $class = 'info';
    break;
  case '3':
    $class = 'warning';
    break;
  default:
    $class = 'danger';
}

// Output.
print '<span style="font-size: 190%;">';
  print '<span class="label label-' . $class . '">';
    print '<span aria-hidden="true" class="glyphicon glyphicon-star"></span> ' . $rating;
  print '</span>';
print '</span>';

?>

