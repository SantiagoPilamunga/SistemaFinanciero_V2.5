<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerMetric $customerMetric
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Customer Metric'), ['action' => 'edit', $customerMetric->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer Metric'), ['action' => 'delete', $customerMetric->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerMetric->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customer Metrics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer Metric'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customerMetrics view content">
            <h3><?= h($customerMetric->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= $customerMetric->hasValue('department') ? $this->Html->link($customerMetric->department->name, ['controller' => 'Departments', 'action' => 'view', $customerMetric->department->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customerMetric->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Customers') ?></th>
                    <td><?= $this->Number->format($customerMetric->total_customers) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quarter') ?></th>
                    <td><?= $this->Number->format($customerMetric->quarter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $this->Number->format($customerMetric->year) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>