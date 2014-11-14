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
	$left_col_fields = array('field-faust-number', 'field-isbn', 'field-author', 'field-dk5', 'field-tags');
	$right_col_fields = array('field-publication-date', 'field-pages', 'field-binding-type', 'field-publisher', 'field-audience');
	$left_col = $right_col = '<div class="col-xs-12 col-sm-6"><table class="table table-hover table-bordered table-striped">';

	// Description and review blocks
	$field_description = 'field-backside-description';
	$field_review = 'field-review';
	$field_review_block = $field_description_block = '<div class="col-xs-12 col-sm-6"><pre>';

	foreach ($fields as $id => $field) {
		// Populating left column
		if (in_array($field->class, $left_col_fields)) {
			$left_col .= '<tr class=' . $field->class . '><td><b>' . $field->label . '</b></td><td>' . $field->content . '</td></tr>';
		}
		// Populating right column
		elseif (in_array($field->class, $right_col_fields)) {
			$right_col .= '<tr class=' . $field->class . '><td><b>' . $field->label . '</b></td><td>' . $field->content . '</td></tr>';
		}
		elseif($field->class === $field_description) {
			$field_review_block .= '<div class="' . $field->class .'"><h4>' . $field->label . '</h4><div class="' . $field->class . '-content">' .  $field->content . '</div>';
		}
		elseif($field->class === $field_review) {
			$field_description_block .= '<div class="' . $field->class .'"><h4>' . $field->label . '</h4><div class="' . $field->class . '-content">' .  $field->content . '</div>';
		}
	}

	$left_col .= '</table></div>';
	$right_col .= '</table></div>';
	$field_review_block .= '</pre></div>';
	$field_description_block .= '</pre></div>';

	print '<div class="container-fluid"><div class="row">' . $left_col . $right_col . '</div><div class="row">' . $field_review_block . $field_description_block . '</div></div>';
?>
