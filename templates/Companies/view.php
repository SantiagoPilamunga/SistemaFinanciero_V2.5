<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="companies view content">
            <h3><?= h($company->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($company->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ruc') ?></th>
                    <td><?= h($company->ruc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($company->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Budget Limit') ?></th>
                    <td><?= $company->budget_limit === null ? '' : $this->Number->format($company->budget_limit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($company->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($company->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Expenses') ?></h4>
                <?php if (!empty($company->expenses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Department') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Expense Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->expenses as $expense) : ?>
                        <tr>
                            <td><?= h($expense->id) ?></td>
                            <td><?= h($expense->department) ?></td>
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