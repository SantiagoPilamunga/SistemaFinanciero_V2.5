<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Expense $expense
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Expenses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="expenses form content">
            <?= $this->Form->create($expense) ?>
            <fieldset>
                <legend><?= __('Add Expense') ?></legend>
                <?php
                    // 1. Selector de Empresa
                    echo $this->Form->control('company_id', [
                        'options' => $companies, 
                        'empty' => 'Seleccione Empresa', 
                        'id' => 'company-id'
                    ]);

                    // 2. Selector de Departamento (Se llena por AJAX al cambiar Empresa)
                    echo $this->Form->control('department_id', [
                        'options' => $departments, 
                        'empty' => 'Seleccione Departamento', 
                        'id' => 'dept-id'
                    ]);

                    // 3. Selector de Categoría (Se llena por AJAX al cambiar Departamento)
                    echo $this->Form->control('category_id', [
                        'options' => $categories, 
                        'empty' => 'Seleccione Categoría', 
                        'id' => 'cat-id'
                    ]);

                    echo $this->Form->control('amount');
                    echo $this->Form->control('description');
                    echo $this->Form->control('expense_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const companySelect = document.getElementById('company-id');
    const deptSelect = document.getElementById('dept-id');
    const catSelect = document.getElementById('cat-id');

    // 1. Cambio de Empresa -> Carga Departamentos
    companySelect.addEventListener('change', function() {
        const companyId = this.value;
        if (companyId) {
            deptSelect.innerHTML = '<option>Cargando...</option>';
            fetch('<?= $this->Url->build(['action' => 'getDepartments']) ?>/' + companyId)
                .then(res => res.json())
                .then(data => {
                    deptSelect.innerHTML = '<option value="">Seleccione Departamento</option>';
                    catSelect.innerHTML = '<option value="">Primero seleccione departamento</option>';
                    Object.keys(data).forEach(key => {
                        let opt = document.createElement('option');
                        opt.value = key;
                        opt.text = data[key];
                        deptSelect.appendChild(opt);
                    });
                });
        }
    });

    // 2. Cambio de Departamento -> Carga Categorías
    deptSelect.addEventListener('change', function() {
        const deptId = this.value;
        if (deptId) {
            catSelect.innerHTML = '<option>Cargando...</option>';
            fetch('<?= $this->Url->build(['action' => 'getCategories']) ?>/' + deptId)
                .then(res => res.json())
                .then(data => {
                    catSelect.innerHTML = '<option value="">Seleccione Categoría</option>';
                    Object.keys(data).forEach(key => {
                        let opt = document.createElement('option');
                        opt.value = key;
                        opt.text = data[key];
                        catSelect.appendChild(opt);
                    });
                });
        }
    });
});
</script>