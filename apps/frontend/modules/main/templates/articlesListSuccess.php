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
        <div class="article">
            <div class="scrolled">
                <h3>Обсуждаем вопросы женского здоровья, беременности и роды, диету, красоту, уход за лицом и телом, а так же многое другое, интересующее наших прекрасных женщин.</h3>
                <table>
                    <?php foreach($subSections as $subsection):?>
                    <tr>
                        <td class="image"><img src="<?php echo $fileBasePath.$subsection->getImage();?>" /></td>
                        <td>
                            <table>
                                <tr>
                                    <td class="title"><a href="/consumers_corner<?php echo $section->getSlug()."/".$subsection->getSlug(); ?>"><?php echo $subsection->getName();?></a></td>
                                </tr>
                                <tr>
                                    <td class="desc"><?php echo $subsection->getContent()->getHtml(ESC_RAW)?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <img class="warning" src="/images/warning.png">
</div>