<script language="JavaScript">
    tinyMCE.init(
        {
            language: "ru",
            theme: "modern",
            mode: "textareas"
        }
    );
</script>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('content/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/newapple/Sites/Lavita/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/newapple/Sites/Lavita/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('content/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'content/delete?
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/newapple/Sites/Lavita/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /Users/newapple/Sites/Lavita/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['html']->renderLabel() ?></th>
        <td>
          <?php echo $form['html']->renderError() ?>
          <?php echo $form['html'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['section_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['section_id']->renderError() ?>
          <?php echo $form['section_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
