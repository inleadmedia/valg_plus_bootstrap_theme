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
<?php if (in_array('purchaser', $user->roles)) : ?>
<?php $count = valg_bkm_show_count($output); ?>

  <?php if ($count && is_numeric($count)) : ?>
  <h4 class="text-center"><?php print $count; ?><br /><small>eks.</small></h4>
  <?php else : ?>
    <?php $data_content = t("Item has either been automatically deselected based on your profile, or you have used all of your budget."); ?>
    <h4 class="text-center" data-toggle="popover" data-trigger="hover" data-placement="left" data-title="<?php print t('Reason'); ?>" data-content="<?php print $data_content; ?>">0<br /><small><?php print t('Reason'); ?></small></h4>
  <?php endif; ?>
<?php endif; ?>
