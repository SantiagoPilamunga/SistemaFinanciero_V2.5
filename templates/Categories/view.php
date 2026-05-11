<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categories view content">
            <h3><?= h($category->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= $category->hasValue('department') ? $this->Html->link($category->department->name, ['controller' => 'Departments', 'action' => 'view', $category->department->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($category->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Weight') ?></th>
                    <td><?= $category->weight === null ? '' : $this->Number->format($category->weight) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Budgets') ?></h4>
                <?php if (!empty($category->budgets)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Amount Limit') ?></th>
                            <th><?= __('Quarter') ?></th>
                            <th><?= __('Year') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($category->budgets as $budget) : ?>
                        <tr>
                            <td><?= h($budget->id) ?></td>
                            <td><?= h($budget->amount_limit) ?></td>
                            <td><?= h($budget->quarter) ?></td>
                            <td><?= h($budget->year) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Budgets', 'action' => 'view', $budget->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Budgets', 'action' => 'edit', $budget->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Budgets', 'action' => 'delete', $budget->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $budget->id),
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
                <h4><?= __('Related Expenses') ?></h4>
                <?php if (!empty($category->expenses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Expense Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($category->expenses as $expense) : ?>
                        <tr>
                            <td><?= h($expense->id) ?></td>
                            <td><?= h($expense->company_id) ?></td>
                            <td><?= h($expense->amount) ?></td>
                            <td><?= h($expense->description) ?></td>
                            <td><?= h($expense->expense_date) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Expenses', 'action' => 'view', $expense->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Expenses', 'action' => 'edit', $expense->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Expenses', 'action' => 'delete', $expense->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $expense->id),
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