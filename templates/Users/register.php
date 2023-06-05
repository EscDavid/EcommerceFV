<?= $this->fetch('css') ?>
<?= $this->Form->create() ?>

<?php if (!empty($errors)) : ?>
    <div class="error-messages">
        <h4>Ten en cuenta lo siguiente:</h4>
        <ul>
            <?php foreach ($errors as $field => $fieldErrors) : ?>
                <?php foreach ($fieldErrors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<div class="form-group">
    <?= $this->Form->control('name', ['type' => 'text','label' => 'Nombre', 'class' => 'form-control', 'required' => true]) ?>
</div>
<div class="form-group">
    <?= $this->Form->control('lastname', ['type' => 'text','label' => 'Apellido', 'class' => 'form-control', 'required' => true]) ?>
</div>
<div class="form-group">
    <?= $this->Form->control('address', ['type' => 'text','label' => 'Direccion', 'class' => 'form-control', 'required' => true]) ?>
</div>
<div class="form-group">
    <?= $this->Form->control('email', ['type' => 'email','label' => 'Correo electronico', 'class' => 'form-control', 'required' => true]) ?>
</div>
<div class="form-group">
    <?= $this->Form->control('password', ['type' => 'password','label' => 'Contraseña', 'class' => 'form-control', 'required' => true]) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('passwordRepeat', ['type' => 'password','label' => 'Repetir Contraseña', 'class' => 'form-control', 'required' => true]) ?>
</div>

<div class="form-group">
    <?= $this->Form->button('Register', ['class' => "form-control btn btn-primary submit px-3"]) ?>
</div>
<div class="w-50 text-md-left">
        <?= $this->Html->link('Iniciar sesion', ['controller' => 'users', 'action' => 'login']) ?>
    </div>


<?= $this->Form->end() ?>
