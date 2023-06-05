<?= $this->fetch('css') ?>
<?= $this->Form->create(); ?>
<div class="form-group">
    <?= $this->Form->control('email', ['type' => 'text', 'class' => 'form-control',  'required' => true]); ?>
</div>

<div class="form-group">
    <?= $this->Form->submit('Enviar', ['class' => "form-control btn btn-primary submit px-3"]); ?>
</div>
<div class="form-group d-md-flex">
    <div class="w-50">

        <?= $this->Html->link('Iniciar sesion', ['controller' => 'users', 'action' => 'login']) ?>
    </div>
    <div class="w-50 text-md-right">
        <?= $this->Html->link('Registarme', ['controller' => 'users', 'action' => 'register']) ?>
    </div>
    <div class="form-group">
        <div class="col-md-12 text-center">
        
        </div>
    </div>
    <?= $this->Form->end(); ?>