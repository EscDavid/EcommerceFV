<?= $this->fetch('css') ?>
<?= $this->Form->create(); ?>
<div class="form-group">
    <?= $this->Form->control('email', ['type' => 'text', 'class' => 'form-control',  'required' => true]); ?>
</div>
<div class="form-group">
    <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control',  'required' => true, 'id' => 'password-field']); ?>
    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
    <div class="w-50 text-md-right">
        <?= $this->Html->link('Olvide mi contraseña', ['style' => "color: #fff",'controller'=>'users','action'=>'recoverPass']) ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->submit('Login', ['class' => "form-control btn btn-primary submit px-3"]); ?>
</div>
<div class="form-group d-md-flex">
    <div class="w-50">

        <label for="remember-me-checkbox" class="checkbox-wrap checkbox-primary">Recuerdame
            <?php echo $this->Form->checkbox('remember_me', ['id' => 'remember-me-checkbox', 'checked' => true]); ?>
            <span class="checkmark"></span>
        </label>
    </div>
    <div class="w-50 text-md-right">
        <?= $this->Html->link('Registarme', ['controller' => 'users', 'action' => 'register']) ?>
    </div>

    <?= $this->Form->end(); ?>