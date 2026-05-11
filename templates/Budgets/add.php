<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Budgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="budgets form content">
            <?= $this->Form->create($budget) ?>
            <fieldset>
                <legend><?= __('Add Budget') ?></legend>
                <?php
                    echo $this->Form->control('category_id', ['options' => $categories]);
                    echo $this->Form->control('amount_limit');
                    echo $this->Form->control('quarter');
                    echo $this->Form->control('year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
