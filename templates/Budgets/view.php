<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Budget'), ['action' => 'edit', $budget->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Budget'), ['action' => 'delete', $budget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $budget->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Budgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Budget'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="budgets view content">
            <h3><?= h($budget->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $budget->hasValue('category') ? $this->Html->link($budget->category->name, ['controller' => 'Categories', 'action' => 'view', $budget->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($budget->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount Limit') ?></th>
                    <td><?= $this->Number->format($budget->amount_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quarter') ?></th>
                    <td><?= $this->Number->format($budget->quarter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $this->Number->format($budget->year) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>