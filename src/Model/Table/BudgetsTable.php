<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Budgets Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \App\Model\Entity\Budget newEmptyEntity()
 * @method \App\Model\Entity\Budget newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Budget> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Budget get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Budget findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Budget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Budget> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Budget|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Budget saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Budget>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Budget> deleteManyOrFail(iterable $entities, array $options = [])
 */
class BudgetsTable extends Table
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

        $this->setTable('budgets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
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
            ->integer('category_id')
            ->notEmptyString('category_id');

        $validator
            ->decimal('amount_limit')
            ->requirePresence('amount_limit', 'create')
            ->notEmptyString('amount_limit');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);

        return $rules;
    }
}
