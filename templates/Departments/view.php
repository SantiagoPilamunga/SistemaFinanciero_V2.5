<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Department'), ['action' => 'edit', $department->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Department'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete # {0}?', $department->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Department'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="departments view content">
            <h3><?= h($department->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $department->hasValue('company') ? $this->Html->link($department->company->name, ['controller' => 'Companies', 'action' => 'view', $department->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($department->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($department->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Categories') ?></h4>
                <?php if (!empty($department->categories)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Weight') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($department->categories as $category) : ?>
                        <tr>
                            <td><?= h($category->id) ?></td>
                            <td><?= h($category->name) ?></td>
                            <td><?= h($category->weight) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $category->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $category->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Categories', 'action' => 'delete', $category->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $category->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Customer Metrics') ?></h4>
                <?php if (!empty($department->customer_metrics)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Total Customers') ?></th>
                            <th><?= __('Quarter') ?></th>
                            <th><?= __('Year') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($department->customer_metrics as $customerMetric) : ?>
                        <tr>
                            <td><?= h($customerMetric->id) ?></td>
                            <td><?= h($customerMetric->total_customers) ?></td>
                            <td><?= h($customerMetric->quarter) ?></td>
                            <td><?= h($customerMetric->year) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CustomerMetrics', 'action' => 'view', $customerMetric->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerMetrics', 'action' => 'edit', $customerMetric->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CustomerMetrics', 'action' => 'delete', $customerMetric->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $customerMetric->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>