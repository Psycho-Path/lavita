<?php use_stylesheet("jquery.mCustomScrollbar.css");?>
<?php use_javascript("jquery.mCustomScrollbar.js");?>
<?php use_javascript("scrollbar.init.js");?>

<div class="wrap">
    <div class="content-wrap">
        <div class="head-wrap">
            <img class="logo" src="/images/logo.png">
            <ul class="menu">
                <?php $counter = 1; foreach($firstLevelSections as $section):?>
                    <li class="btn-<?php echo $counter;?> <?php if($section->getId() == $firstLevelSection->getId()) echo ' active';?>">
                        <a href="/<?php echo $section->getSlug();?>"><?php echo $section->getName();?></a>
                        <?php if($section->getId() == $firstLevelSection->getId()):?>
                            <?php if($section->getSlug()=="consumers_corner" || $section->getSlug()=="about_company"):?>
                                <div class="submenu">
                                    <?php foreach($firstLevelSubsections as $flSubsection):?>
                                        <?php if(!$flSubsection->getPriority()):?>
                                            <a href="/<?php echo $section->getSlug()."/".$flSubsection->getSlug();?>"><?php echo $flSubsection->getName()?></a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                    <?php $counter++; endforeach;?>
            </ul>
            <div class="clear"></div>
            <img class="hearts1" src="/images/hearts1.png">
            <img class="hearts2" src="/images/hearts2.png">
        </div>
        <div class="scrolled" style="height: 730px; overflow: auto;">
            <div class="simple-wrap">
                <h1><?php echo $currentSection->getName();?></h1>
                <?php echo $sf_data->getRaw('html');?>
            </div>
        </div>
    </div>
    <img class="warning" src="/images/warning.png">
</div>