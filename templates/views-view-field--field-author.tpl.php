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
  $editable_fields = variable_get('valg_quickedit_enabled_fields', array());
  if (array_key_exists($field->field, $editable_fields)) {
    $data_type = 'select2';
    print '<label>by:</label>
           <a href="?field_author_tid=&quot;' . $output . '&quot;">
              <span class="' . $editable_fields[$field->field] . '" data-pk="' . $row->nid . '" data-name="' . $field->field . '" data-type="' . $data_type . '">' . $output . '</span>
          </a>';
  }
  else {
    print '<label>by:</label><a href="?field_author_tid[]=&quot;' . $output . '&quot;">' . $output . '</a>';
  }
