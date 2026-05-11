<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <script src="https://jquery.com"></script>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Cake</span>PHP</a>
        </div>
        <div class="top-nav-links">
            <a target="_blank" rel="noopener" href="https://book.cakephp.org/5/">Documentation</a>
            <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a>

            <?php
            // Obtenemos los datos del usuario desde la identidad de la sesión
            $user = $this->request->getAttribute('identity');
            if ($user): ?>
                <?= $this->Html->link('Compañías', ['controller' => 'Companies', 'action' => 'index']) ?>
                <?= $this->Html->link('Gastos', ['controller' => 'Expenses', 'action' => 'index']) ?>
                <?= $this->Html->link('Usuarios', ['controller' => 'Users', 'action' => 'index']) ?>

                <span>Hola, <?= h($user->email) ?></span>
                <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'logout-button']) ?>
            <?php else: ?>
                <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login']) ?>
            <?php endif; ?>
        </div>

    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
