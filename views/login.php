<?php
/**
 * @var $this \app\core\View
 * @var $model \app\models\LoginForm
 */
$this->title = 'Login Page';
?>
<?php $form = \app\core\form\Form::begin('/login', 'post')?>
    <!--create My Form by PHP-->

<?php echo $form->inputField($model, 'email')?>
<?php echo $form->inputField($model, 'password')->typePassword()?>
    <div class="col-6">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
<?php echo \app\core\form\Form::end()?>