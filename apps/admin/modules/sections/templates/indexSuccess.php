<div class="section-screen-wrapper">
    <div class="section-screen-header">
<!--        TODO: top menu-->
    </div>
    <div class="section-screen-top-titles">
        <h3>Панель администрирования сайта Lavita.ru</h3>
        <p><?php if($path): echo $path; endif;?></p>
    </div>
    <div class="section-screen-table-wrapper">
        <table class="section-screen-table"> <!--cellspacing="0"-->
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Подразделы</th>
                    <th>Контент</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $counter = 0;
                    foreach ($sections as $section):
                    ?>
                <tr <?php if($counter%2==0) echo "class=\"even\"";?> >
                    <td><a href="<?php echo url_for('sections/edit?id='.$section->getId()) ?>"><?php echo $section->getName() ?></a></td>
                    <td><a href="<?php echo url_for("@sections_level?slug=".($section->getSlug() ? $section->getSlug() :"first_level"));?>">Перейти</a></td>
                    <?php if($section->getType() == "WithHTMLContent"): ?>
                    <td><a href="<?php if($section->getContent()->getId() == 0): echo url_for("content/new?section_id=".$section->getId()); else: echo url_for("content/edit?id=".$section->getContent()->getId()); endif;?>">Перейти</a></td>
                    <?php else: ?>
                        <td>&ndash;</td>
                    <?php endif; ?>
                    <td></td>
                </tr>
                <?php
                    $counter++;
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
    <?php if($showNavigationBar):?>
    <div class="section-screen-navigation">
        <a href="<?php if($slug && $slug != "first_level"): echo url_for('sections/new?parent='.$slug); else: echo url_for('sections/new'); endif; ?>"><div class="section-screen-navigation-add-new"><span>Создать новый раздел</span></div></a>
    </div>
    <?php endif; ?>
</div>

<!--<h3>--><?php //if($path): echo $path; endif;?><!--</h3>-->
<!---->
<!--<table>-->
<!--  <thead>-->
<!--    <tr>-->
<!--      <th>Id</th>-->
<!--      <th>Name</th>-->
<!--      <th>Slug</th>-->
<!--      <th>Parent</th>-->
<!--      <th>Type</th>-->
<!--      <th>Priority</th>-->
<!--      <th>Created at</th>-->
<!--      <th>Updated at</th>-->
<!--    </tr>-->
<!--  </thead>-->
<!--  <tbody>-->
<!--    --><?php //foreach ($sections as $section): ?>
<!--    <tr>-->
<!--      <td><a href="--><?php //echo url_for('sections/edit?id='.$section->getId()) ?><!--">--><?php //echo $section->getId() ?><!--</a></td>-->
<!--      <td>--><?php //echo $section->getName() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getSlug() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getParentId() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getType() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getPriority() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getCreatedAt() ?><!--</td>-->
<!--      <td>--><?php //echo $section->getUpdatedAt() ?><!--</td>-->
<!--    </tr>-->
<!--    --><?php //endforeach; ?>
<!--  </tbody>-->
<!--</table>-->
<!---->
<!--  <a href="--><?php //echo url_for("@new_section") ?><!--">New</a>-->
