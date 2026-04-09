<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \App\Model\Table\ExpensesTable&\Cake\ORM\Association\HasMany $Expenses
 *
 * @method \App\Model\Entity\Company newEmptyEntity()
 * @method \App\Model\Entity\Company newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Company findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Company saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CompaniesTable extends Table
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

        $this->setTable('companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Expenses', [
            'foreignKey' => 'company_id',
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('ruc')
            ->maxLength('ruc', 20)
            ->requirePresence('ruc', 'create')
            ->notEmptyString('ruc');

        $validator
            ->decimal('budget_limit')
            ->allowEmptyString('budget_limit');

        return $validator;
    }
}
