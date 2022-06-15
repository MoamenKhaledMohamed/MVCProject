<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\ContactForm
 */
$this->title = 'Contact Page';
?>
<?php $form = \app\core\form\Form::begin('/contact', 'post')?>
    <!--create My Form by PHP-->

<?php echo $form->inputField($model, 'subject')?>
<?php echo $form->inputField($model, 'email')?>
<?php echo $form->textAreaField($model, 'body')?>
    <div class="col-6">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
<?php echo \app\core\form\Form::end()?>