<?php $form = \app\core\form\Form::begin('/register', 'post')?>
<!--create My Form by PHP-->

<?php echo $form->field($model, 'full_name')?>
<?php echo $form->field($model, 'email')?>
<?php echo $form->field($model, 'password')->typePassword()?>
<?php echo $form->field($model, 'confirm_password')->typePassword()?>
<div class="col-6">
    <button type="submit" class="btn btn-primary">Register</button>
</div>
<?php \app\core\form\Form::end()?>