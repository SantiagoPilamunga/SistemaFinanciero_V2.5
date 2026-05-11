<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $department_id
 * @property string $name
 * @property int|null $weight
 *
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\Budget[] $budgets
 * @property \App\Model\Entity\Expense[] $expenses
 */
class Category extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'department_id' => true,
        'name' => true,
        'weight' => true,
        'department' => true,
        'budgets' => true,
        'expenses' => true,
    ];
}
