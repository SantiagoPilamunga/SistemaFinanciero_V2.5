<?= $this->Html->css('analisis') ?>

<div class="filter-box" style="background: #f4f4f4; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <div style="display: flex; gap: 15px; align-items: center;">
        <div>
            <label>Año:</label>
            <?php /** @var array $year */?>
            <?php /** @var array $quarter */?>
            <?= $this->Form->select('year', [2023 => '2023', 2024 => '2024', 2025 => '2025'], ['value' => $year]) ?>
        </div>
        <div>
            <label>Trimestre:</label>
            <?= $this->Form->select('quarter', [1 => 'T1', 2 => 'T2', 3 => 'T3', 4 => 'T4'], ['value' => $quarter]) ?>
        </div>
        <div>
            <?= $this->Form->button('Analizar Periodo', ['style' => 'margin-top: 20px;']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<div class="analysis index content">
    <h2>Panel de Inteligencia Financiera</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Departamento</th>
                <th>Gasto Total</th>
                <th>Índice Eficiencia (IEO)</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var array $results */ ?>
            <?php foreach ($results as $res): ?>
            <?php 
                // Se asigna la clase según el estado
                $claseFila = '';
                if ($res['status'] == 'CRÍTICO') $claseFila = 'bg-critico';
                elseif ($res['status'] == 'ESTABLE') $claseFila = 'bg-estable';
                elseif ($res['status'] == 'EXCELENTE') $claseFila = 'bg-excelente';
            ?>
            <tr class="<?= $claseFila ?>">
                <td><strong><?= h($res['name']) ?></strong></td>
                <td>$<?= number_format($res['total_spent'], 2) ?></td>
                <td><?= number_format($res['efficiency_index'], 2) ?></td>
                <td>
                    <span class="badge"><?= $res['status'] ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="alerta-sugerencia">
    <h3>📢 Recomendaciones Estratégicas</h3>
    <ul>
        <?php foreach ($results as $res): ?>
            <li>
                <?php if ($res['status'] == 'CRÍTICO'): ?>
                    ⚠️ El departamento de <strong><?= h($res['name']) ?></strong> está siendo ineficiente. 
                    Se recomienda auditar los gastos de alto peso y reducir presupuesto un 10%.
                <?php elseif ($res['status'] == 'EXCELENTE'): ?>
                    ✅ <strong><?= h($res['name']) ?></strong> es un modelo de éxito. 
                    Se recomienda aumentar su presupuesto para escalar el volumen de clientes.
                <?php else: ?>
                    ℹ️ <strong><?= h($res['name']) ?></strong> se mantiene estable. Mantener presupuesto actual.
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

