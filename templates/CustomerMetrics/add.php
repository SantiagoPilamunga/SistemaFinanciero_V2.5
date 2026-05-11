<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerMetric $customerMetric
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Customer Metrics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customerMetrics form content">
            <?= $this->Form->create($customerMetric) ?>
            <fieldset>
                <legend><?= __('Add Customer Metric') ?></legend>
                <?php
                    echo $this->Form->control('department_id', ['options' => $departments]);
                    echo $this->Form->control('total_customers');
                    echo $this->Form->control('quarter', [
                        'type' => 'select',
                        'options' => [1 => 'Trimestre 1', 2 => 'Trimestre 2', 3 => 'Trimestre 3', 4 => 'Trimestre 4'],
                        'label' => 'Trimestre'
                    ]);
                    echo $this->Form->control('year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
