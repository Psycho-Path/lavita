<?php if($section->getType() == "WithHTMLContent"): ?>
<script language="JavaScript">
    tinyMCE.init(
        {
            language: "ru",
            theme: "modern",
            mode: "textareas",
            plugins: ["image", "link", "fullscreen", "code", "colorpicker"]
        }
    );
</script>
<?php endif; ?>

<?php

    $newForm = false;
    $formActionUrl = null;
    if(count($content)==0)
    {
        $newForm = true;
        $formActionUrl = url_for("content/create");
    }
    else
    {
        $formActionUrl = url_for("content/update?id=".$content->getId());
    }

?>

<form class="sections-form" action="<?php echo $formActionUrl; ?>" method="post" enctype="multipart/form-data">
    <table class="sections-form-table">
        <tr>
            <td class="sections-form-description">Раздел:&nbsp</td>
            <?php if(count($sectionsList) == 0 && count($section) == 0):?>
                <td>ERROR</td>
            <?php else: ?>
                <td>
                    <select name="section_id">
                        <?php foreach($sectionsList as $sectionObject):?>
                            <option value="<?php echo $sectionObject->getId(); ?>" <?php if($sectionObject->getId() == $section->getId()) echo "selected"?>><?php echo $sectionObject->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            <?php endif;?>
        </tr>
        <tr>
            <td class="sections-form-description">Содержание:&nbsp</td>
            <td><textarea rows="10" cols="45" name="html"><?php if($content) echo $content->getHtml(); ?></textarea></td>
        </tr>
        <tr>
            <td class="sections-form-description">Отобразить на сайте:&nbsp</td>
            <td><input type="checkbox" name="visibility" <?php if(!$content): echo ""; else: if($content->getVisibility())echo "checked"; endif; ?>></td>
        </tr>
    </table>
    <input type="submit" value="Сохранить">
</form>