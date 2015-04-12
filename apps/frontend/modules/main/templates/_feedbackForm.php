<div class="question-panel">
    <form method="POST" name="contact_form" action="/frontend_dev.php/consumers_corner/faq">

        <label for="feedback_name">Ваше имя * </label>
        <br>
        <input type="text" name="feedback_name" value="">
        <br>
        <label for="feedback_email">Email * </label>
        <br>
        <input type="text" name="feedback_email" value="">
        <br>
        <label for="feedback_message">Сообщение*</label>
        <br>
        <textarea name="feedback_message"></textarea>
        <br>
        <img src="<?php echo '/lib/vendor/Captcha/captcha_code_file.php?rand='.rand();?>" id="captchaimg" >
        <br>
        <input id="6_letters_code" name="6_letters_code" placeholder="Введите сюда код картинки" type="text">
        <br>
        <small>Нажмите <a href='javascript: refreshCaptcha();'>здесь</a> для того, что бы сменить картинку</small>
        <br>
        <input type="submit" value="Отправить" name="Отправить">
    </form>
    <img src="/images/txt.png" alt="" class="txt">
</div>

<script language="JavaScript">
    // Code for validating the form
    // Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
    // for details
    var frmvalidator  = new Validator("contact_form");
    //remove the following two lines if you like error message box popups
    frmvalidator.EnableOnPageErrorDisplaySingleBox();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("feedback_name","req","Пожалуйста, введите имя");
    frmvalidator.addValidation("feedback_email","req","Пожалуйста введите свой email");
    frmvalidator.addValidation("feedback_email","email","Пожалуйста, введите правильный email адрес");
</script>
<script language='JavaScript' type='text/javascript'>
    function refreshCaptcha()
    {
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    }
</script>