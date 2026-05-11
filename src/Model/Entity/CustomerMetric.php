<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerMetric Entity
 *
 * @property int $id
 * @property int $department_id
 * @property int $total_customers
 * @property int $quarter
 * @property int $year
 *
 * @property \App\Model\Entity\Department $department
 */
class CustomerMetric extends Entity
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
        'total_customers' => true,
        'quarter' => true,
        'year' => true,
        'department' => true,
    ];
}
