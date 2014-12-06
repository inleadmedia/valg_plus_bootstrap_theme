<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php
  // Left and right columns of show more
  $left_col_fields = array(
    'field-faust-number',
    'field-isbn',
    'field-author',
    'field-dk5',
    'field-language',
    'field-publisher',
    'field-publication-date',
  );
  $right_col_fields = array(
    'field-group',
    'field-pages',
    'field-binding-type',
    'field-title-complete',
    'field-audience',
    'field-tags',
  );

  $left_col = $right_col = '<div class="col-xs-12 col-sm-6"><table class="table table-bordered table-condensed table-striped table-responsive">';

  // Description and review blocks
  $field_description = 'field-backside-description';
  $field_review = 'field-review';
  $field_review_block = $field_description_block = '<div class="col-xs-12 col-md-6">';


  foreach ($fields as $id => $field) {
    // Generic column setup.
    $column_values = '<tr class=' . $field->class . '>' . '<td class="col-lg-4 col-md-5 col-sm-4 col-xs-6">' . $field->label_html . '</td>' . '<td>' . $field->content . '</td>' . '</tr>';

    if (in_array($field->class, $left_col_fields)) {
      $left_col .= $column_values;
    }
    elseif (in_array($field->class, $right_col_fields)) {
      $right_col .= $column_values;
    }

    // Generic text setup.
    $text_block = $field->wrapper_prefix . '<div class="panel-heading">' . $field->label_html . '</div>' . $field->content . $field->wrapper_suffix;

    if($field->class === $field_description) {
      $field_review_block .= $text_block;
    }
    elseif($field->class === $field_review) {
      $field_description_block .= $text_block;
    }
  }

  $left_col .= '</table></div>';
  $right_col .= '</table></div>';
  $field_review_block .= '</div>';
  $field_description_block .= '</div>';

  print '<div class="container-fluid"><div class="row">' . $left_col . $right_col . '</div><div class="row">' . $field_review_block . $field_description_block . '</div></div>';
