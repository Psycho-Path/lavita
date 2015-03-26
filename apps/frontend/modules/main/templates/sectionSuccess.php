<div class="wrap">
    <div class="content-wrap">
        <div class="head-wrap">
            <img class="logo" src="/images/logo.png">
            <ul class="menu">
                <?php $counter = 1; foreach($firstLevelSections as $section):?>
                    <li class="btn-<?php echo $counter;?>"><a href="#"><?php echo $section->getName();?></a></li>
                    <?php $counter++; endforeach;?>
                <!--                <li class="btn-2"><a href="#">Все о женском здоровье</a></li>-->
                <!--                <li class="btn-3"><a href="#">Уголок потребителя</a></li>-->
                <!--                <li class="btn-4"><a href="#">О компании производителе</a></li>-->
            </ul>
            <div class="clear"></div>
            <img class="hearts1" src="/images/hearts1.png">
            <img class="hearts2" src="/images/hearts2.png">
        </div>
        <?php echo $sf_data->getRaw('html');?>
    </div>
    <img class="warning" src="/images/warning.png">
</div>