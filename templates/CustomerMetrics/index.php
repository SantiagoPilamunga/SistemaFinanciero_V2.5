<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CustomerMetric> $customerMetrics
 */
?>
<div class="customerMetrics index content">
    <?= $this->Html->link(__('New Customer Metric'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Customer Metrics') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('department_id') ?></th>
                    <th><?= $this->Paginator->sort('total_customers') ?></th>
                    <th><?= $this->Paginator->sort('quarter') ?></th>
                    <th><?= $this->Paginator->sort('year') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customerMetrics as $customerMetric): ?>
                <tr>
                    <td><?= $this->Number->format($customerMetric->id) ?></td>
                    <td><?= $customerMetric->hasValue('department') ? $this->Html->link($customerMetric->department->name, ['controller' => 'Departments', 'action' => 'view', $customerMetric->department->id]) : '' ?></td>
                    <td><?= $this->Number->format($customerMetric->total_customers) ?></td>
                    <td><?= $this->Number->format($customerMetric->quarter) ?></td>
                    <td><?= $this->Number->format($customerMetric->year) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $customerMetric->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customerMetric->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $customerMetric->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $customerMetric->id),
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