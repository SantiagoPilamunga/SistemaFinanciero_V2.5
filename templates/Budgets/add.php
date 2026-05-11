<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget $budget
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Budgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="budgets form content">
            <?= $this->Form->create($budget) ?>
            <fieldset>
                <legend><?= __('Add Budget') ?></legend>
                <?php   
                    // 1. Selector de Departamento (Padre)
                    echo $this->Form->control('department_id', [
                        'options' => $departments, 
                        'empty' => 'Seleccione Departamento', 
                        'id' => 'dept-id',
                        'required' => true
                    ]);
                    
                    // 2. Selector de Categoría (Hijo - Se llena por AJAX)
                    echo $this->Form->control('category_id', [
                        'options' => $categories, 
                        'empty' => 'Primero seleccione un departamento', 
                        'id' => 'cat-id',
                        'required' => true
                    ]);

                    echo $this->Form->control('amount_limit');
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


<script>
document.addEventListener('DOMContentLoaded', function() {
    var deptSelect = document.getElementById('dept-id');
    var catSelect = document.getElementById('cat-id');

    deptSelect.addEventListener('change', function() {
        var deptId = this.value;
        
        // Esta alerta te confirmará si el script detecta el cambio
        console.log("Cambiando a departamento ID: " + deptId);

        if (deptId) {
            // Limpiamos y avisamos que está cargando
            catSelect.innerHTML = '<option value="">Cargando categorías...</option>';

            fetch('<?= $this->Url->build(['action' => 'getCategories']) ?>/' + deptId)
                .then(response => {
                    if (!response.ok) throw new Error('Error en la red');
                    return response.json();
                })
                .then(data => {
                    catSelect.innerHTML = '<option value="">Seleccione Categoría</option>';
                    // Llenamos el dropdown con los datos recibidos
                    Object.keys(data).forEach(function(key) {
                        var option = document.createElement('option');
                        option.value = key;
                        option.text = data[key];
                        catSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    catSelect.innerHTML = '<option value="">Error al cargar</option>';
                });
        } else {
            catSelect.innerHTML = '<option value="">Primero seleccione departamento</option>';
        }
    });
});
</script>
