<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\User
 */
$this->title = 'Register Page';
?>
<?php $form = \app\core\form\Form::begin('/register', 'post')?>
<!--create My Form by PHP-->

<?php echo $form->inputField($model, 'full_name')?>
<?php echo $form->inputField($model, 'email')?>
<?php echo $form->inputField($model, 'password')->typePassword()?>
<?php echo $form->inputField($model, 'confirm_password')->typePassword()?>
<div class="col-6">
    <button type="submit" class="btn btn-primary">Register</button>
</div>
<?php \app\core\form\Form::end()?>