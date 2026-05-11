<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Expense $expense
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Expense'), ['action' => 'edit', $expense->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Expense'), ['action' => 'delete', $expense->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expense->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Expenses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Expense'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="expenses view content">
            <h3><?= h($expense->department) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $expense->hasValue('company') ? $this->Html->link($expense->company->name, ['controller' => 'Companies', 'action' => 'view', $expense->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($expense->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category Id') ?></th>
                    <td><?= $this->Number->format($expense->category_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($expense->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expense Date') ?></th>
                    <td><?= h($expense->expense_date) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($expense->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>