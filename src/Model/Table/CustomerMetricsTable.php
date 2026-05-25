<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerMetrics Model
 *
 * @property \App\Model\Table\DepartmentsTable&\Cake\ORM\Association\BelongsTo $Departments
 *
 * @method \App\Model\Entity\CustomerMetric newEmptyEntity()
 * @method \App\Model\Entity\CustomerMetric newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CustomerMetric> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerMetric get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CustomerMetric findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CustomerMetric patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CustomerMetric> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerMetric|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CustomerMetric saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CustomerMetric>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CustomerMetric>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CustomerMetric>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CustomerMetric> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CustomerMetric>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CustomerMetric>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CustomerMetric>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CustomerMetric> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CustomerMetricsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('customer_metrics');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('department_id')
            ->notEmptyString('department_id');

        $validator
            ->integer('total_customers')
            ->requirePresence('total_customers', 'create')
            ->notEmptyString('total_customers')
            ->greaterThanOrEqual('total_customers', 0,
             'El total de clientes debe ser mayor o igual a 0');

        $validator
            ->integer('quarter')
            ->requirePresence('quarter', 'create')
            ->notEmptyString('quarter', 'El trimestre es obligatorio')
            ->add('quarter', 'range', [
                'rule' => ['range', 1, 4],
                'message' => 'El trimestre debe ser un valor entre 1 y 4'
            ]);

        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['department_id'], 'Departments'), ['errorField' => 'department_id']);

        return $rules;
    }
}
