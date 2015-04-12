<div class="question-panel">
    <form method="POST" name="contact_form" action="/consumers_corner/faq">

        <label for="name">Ваше имя * </label>
        <br>
        <input type="text" name="name" value="">
        <br>
        <label for="email">Email * </label>
        <br>
        <input type="text" name="email"	value="">
        <br>
        <label for="message">Сообщение*</label>
        <br>
        <textarea name="message"></textarea>
        <br>
        <img src="<?php echo '/lib/vendor/Captcha/captcha_code_file.php?rand='.rand();?>" id="captchaimg" >
        <br>
        <input id="6_letters_code" name="6_letters_code" placeholder="Введите сюда код картинки" type="text">
        <br>
        <input type="submit" value="Submit" name="Отправить">
    </form>
    <img src="/images/txt.png" alt="" class="txt">
</div>