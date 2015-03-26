<?php

    $newForm = false;
    $formActionUrl = null;
    if(count($section)==0)
    {
        $newForm = true;
        $formActionUrl = url_for("sections/create");
    }
    else
    {
        $formActionUrl = url_for("sections/update?id=".$section->getId());
    }

?>

<form class="sections-form" action="<?php echo $formActionUrl; ?>" method="post" enctype="multipart/form-data">
    <table class="sections-form-table">
        <tr>
            <td class="sections-form-description">Название:&nbsp</td>
            <td><input type="text" name="name" value="<?php if($newForm): echo ""; else: echo $section->getName(); endif; ?>"></td>
        </tr>
        <tr>
            <td class="sections-form-description">Slug:&nbsp</td>
            <td><input type="text" name="slug" value="<?php if($newForm): echo ""; else: echo $section->getSlug(); endif; ?>"></td>
        </tr>
        <tr>
            <td class="sections-form-description">Родительский раздел:&nbsp</td>
            <?php if(count($parentsList) == 0 && count($parent) == 0):?>
            <td><input type="text" name="parent_id" value="<?php if($newForm): if($parent){ echo $parent->getName(); }else{ echo "";} else: echo $section->getParentId(); endif; ?>"></td>
            <?php else: ?>
                <td>
                    <select name="parent_id">
                        <?php foreach($parentsList as $parentObject):?>
                        <option value="<?php echo $parentObject->getId(); ?>" <?php if($parentObject->getId() == $parent->getId()) echo "selected"?>><?php echo $parentObject->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            <?php endif;?>
        </tr>
        <tr>
            <td class="sections-form-description">Тип:&nbsp</td>
            <td><select name="type">
                <option disabled <?php if($newForm) echo "selected"?>>--Выберите тип раздела--</option>
                <option value="WithoutContent" <?php if(!$newForm && $section->getType() == "WithoutContent") echo "selected"?>>Раздел без контента</option>
                <option value="WithUniqueContent" <?php if(!$newForm && $section->getType() == "WithUniqueContent") echo "selected"?>>Раздел с кникальным HTML-контентом</option>
                <option value="WithHTMLContent" <?php if(!$newForm && $section->getType() == "WithHTMLContent") echo "selected"?>>Раздел с типовым HTML-контентом</option>
                <option value="WithListContent" <?php if(!$newForm && $section->getType() == "WithListContent") echo "selected"?>>Раздел со списком подразделов</option>
            </select></td>
        </tr>
        <tr>
            <td class="sections-form-description">Приоритет:&nbsp</td>
            <td><input type="checkbox" name="priority" <?php if($newForm): echo ""; else: if($section->getPriority())echo "checked"; endif; ?>></td>
        </tr>
    </table>
    <input type="submit" value="Сохранить">
</form>