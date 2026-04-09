<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Expenses Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\Expense newEmptyEntity()
 * @method \App\Model\Entity\Expense newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Expense> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Expense get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Expense findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Expense patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Expense> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Expense|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Expense saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Expense>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Expense>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Expense>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Expense> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Expense>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Expense>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Expense>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Expense> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ExpensesTable extends Table
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

        $this->setTable('expenses');
        $this->setDisplayField('department');
        $this->setPrimaryKey('id');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
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
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->scalar('department')
            ->maxLength('department', 50)
            ->requirePresence('department', 'create')
            ->notEmptyString('department');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->date('expense_date')
            ->requirePresence('expense_date', 'create')
            ->notEmptyDate('expense_date');

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
