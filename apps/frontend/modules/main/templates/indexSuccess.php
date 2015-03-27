<div class="wrap">
    <div class="content-wrap">
        <div class="head-wrap">
            <img class="logo" src="/images/logo.png">
            <ul class="menu">
                <?php $counter = 1; foreach($firstLevelSections as $section):?>
                <li class="btn-<?php echo $counter;?>"><a href="/<?php echo $section->getSlug();?>"><?php echo $section->getName();?></a></li>
                <?php $counter++; endforeach;?>
            </ul>
            <div class="clear"></div>
            <img class="hearts1" src="/images/hearts1.png">
            <img class="hearts2" src="/images/hearts2.png">
        </div>
        <div class="content main">

            <?php if($content):?>
            <?php echo $sf_data->getRaw('html');?>
            <?php endif; ?>
        </div>
    </div>
    <img class="warning" src="/images/warning.png">
</div>