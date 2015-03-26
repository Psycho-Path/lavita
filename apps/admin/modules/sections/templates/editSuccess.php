<div class="section-screen-wrapper">
    <div class="section-screen-header">
        <!--        TODO: top menu-->
    </div>
    <div class="section-screen-top-titles">
        <h3>Панель администрирования сайта Lavita.ru</h3>
        <p><?php $path=null; if($path): echo $path; endif;?></p>
    </div>
    <div class="section-screen-form-wrapper">
<!--        --><?php //include_partial('form', array('form' => $form)) ?>
        <?php include_component('sections', "newform"); ?>
    </div>
    <div class="section-screen-navigation">
        <a href="<?php echo $sf_context->getUser()->getAttribute('back_url'); ?>"><div class="section-screen-navigation-back"><span>Назад к списку</span></div></a>
        <a href="<?php echo url_for('sections/delete?id='.$sectionId); ?>"><div class="section-screen-navigation-delete"><span>Удалить</span></div></a>
    </div>
</div>

