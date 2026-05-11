<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Budget> $budgets
 */
?>
<div class="budgets index content">
    <?= $this->Html->link(__('New Budget'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Budgets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('amount_limit') ?></th>
                    <th><?= $this->Paginator->sort('quarter') ?></th>
                    <th><?= $this->Paginator->sort('year') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($budgets as $budget): ?>
                <tr>
                    <td><?= $this->Number->format($budget->id) ?></td>
                    <td><?= $budget->hasValue('category') ? $this->Html->link($budget->category->name, ['controller' => 'Categories', 'action' => 'view', $budget->category->id]) : '' ?></td>
                    <td><?= $this->Number->format($budget->amount_limit) ?></td>
                    <td><?= $this->Number->format($budget->quarter) ?></td>
                    <td><?= $this->Number->format($budget->year) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $budget->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $budget->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $budget->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $budget->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>