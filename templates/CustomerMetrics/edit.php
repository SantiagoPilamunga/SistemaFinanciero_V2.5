<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerMetric $customerMetric
 * @var string[]|\Cake\Collection\CollectionInterface $departments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $customerMetric->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $customerMetric->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Customer Metrics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customerMetrics form content">
            <?= $this->Form->create($customerMetric) ?>
            <fieldset>
                <legend><?= __('Edit Customer Metric') ?></legend>
                <?php
                    echo $this->Form->control('department_id', ['options' => $departments]);
                    echo $this->Form->control('total_customers');
                    echo $this->Form->control('quarter');
                    echo $this->Form->control('year');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
