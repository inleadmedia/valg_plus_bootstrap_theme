    <?php
    /**
    * @file
    * This template handles the layout of the views exposed filter form.
    *
    * Variables available:
    * - $widgets: An array of exposed form widgets. Each widget contains:
    * - $widget->label: The visible label to print. May be optional.
    * - $widget->operator: The operator for the widget. May be optional.
    * - $widget->widget: The widget itself.
    * - $sort_by: The select box to sort the view using an exposed form.
    * - $sort_order: The select box with the ASC, DESC options to define order. May be optional.
    * - $items_per_page: The select box with the available items per page. May be optional.
    * - $offset: A textfield to define the offset of the view. May be optional.
    * - $reset_button: A button to reset the exposed filter applied. May be optional.
    * - $button: The submit button for the form.
    *
    * @ingroup views_templates
    */
    ?>
    <?php if (!empty($q)): ?>
      <?php
      // This ensures that, if clean URLs are off, the 'q' is added first so that
      // it shows up first in the URL.
      print $q;
      ?>
    <?php endif; ?>

    <div class="">
      <div class="">
        <?php foreach ($widgets as $id => $widget): ?>
          <div class="panel panel-default">
          <?php if (!empty($widget->label)): ?>
            <div class="panel-heading">
              <h3 class="panel-title">
                <?php print $widget->label; ?>
              </h3>
            </div>
          <?php endif; ?>
          <?php if (!empty($widget->operator)): ?>
            <div class="views-operator">
              <?php print $widget->operator; ?>
            </div>
          <?php endif; ?>
          <div class="panel-body">
            <?php print $widget->widget; ?>
          </div>
          <?php if (!empty($widget->description)): ?>
            <div class="panel-footer">
              <small><?php print $widget->description; ?></small>
            </div>
          <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <?php if (!empty($sort_by)): ?>
          <div class="well">
            <?php print $sort_by; ?>
            <?php print $sort_order; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($items_per_page)): ?>
          <div class="well">
            <?php print $items_per_page; ?>
            <?php if (!empty($offset)): ?>
                <?php print $offset; ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <div class="btn-group btn-group-justified" role="group">
          <?php if (!empty($reset_button)): ?>
            <div class="btn-group" role="group">
              <?php print $reset_button; ?>
            </div>
          <?php endif; ?>
          <div class="btn-group" role="group">
            <?php print $button; ?>
          </div>
        </div>
      </div>
    </div>

