<?= $this->fetch('css') ?>
<?= $this->Form->create(); ?>

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
    <?= $this->Form->control('pwd', ['type' => 'password', 'class' => 'form-control', 'label' => 'Contraseña', 'required' => true]); ?>
</div>
<div class="form-group">
    <?= $this->Form->control('pwdRepeat', ['type' => 'password', 'class' => 'form-control', 'label' => 'Repetir Contraseña', 'required' => true]); ?>
</div>

<div class="form-group">
    <?= $this->Form->submit('Cambiar contraseña', ['class' => "form-control btn btn-primary submit px-3"]); ?>
</div>
<div class="form-group d-md-flex">
    
    <div class="form-group">
        <div class="col-md-12 text-center">
        
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>


