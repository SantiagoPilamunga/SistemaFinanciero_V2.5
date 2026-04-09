<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Login de Sistema Financiero</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend>Por favor ingrese su email y contraseña</legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Entrar')); ?>
    <?= $this->Form->end() ?>

    <hr>
    <?= $this->Html->link("¿No tienes cuenta? Regístrate aquí",
     ['action' => 'add'], ['class' => 'button secondary']) ?>
</div>
