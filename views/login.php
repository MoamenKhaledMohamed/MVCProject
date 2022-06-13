<?php $form = \app\core\form\Form::begin('/login', 'post')?>
    <!--create My Form by PHP-->

<?php echo $form->field($model, 'email')?>
<?php echo $form->field($model, 'password')->typePassword()?>
    <div class="col-6">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
<?php \app\core\form\Form::end()?>