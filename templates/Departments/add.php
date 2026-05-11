<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="departments form content">
            <?= $this->Form->create($department) ?>
            <fieldset>
                <legend><?= __('Add Department') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#company-id').change(function() {
        var companyId = $(this).val();
        if (companyId) {
            $.ajax({
                url: '<?= $this->Url->build(['action' => 'getByCompany']) ?>/' + companyId,
                type: 'GET',
                success: function(data) {
                    $('#department-id').empty(); // Limpiar el dropdown de departamentos
                    $('#department-id').append('<option value="">Seleccione un departamento</option>');
                    $.each(data, function(key, value) {
                        $('#department-id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    });
});
</script>
