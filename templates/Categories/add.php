<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="categories form content">
            <?= $this->Form->create($category) ?>
            <fieldset>
                <legend><?= __('Add Category') ?></legend>
                <?php
                    echo $this->Form->control('department_id', ['options' => $departments]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('weight');
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
