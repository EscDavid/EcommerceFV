<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pwdreset Model
 *
 * @method \App\Model\Entity\Pwdreset newEmptyEntity()
 * @method \App\Model\Entity\Pwdreset newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pwdreset[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pwdreset get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pwdreset findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pwdreset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pwdreset[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pwdreset|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pwdreset saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pwdreset[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pwdreset[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pwdreset[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pwdreset[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PwdResetTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTable('pwdreset');
        $this->setDisplayField('pwdResetId');
        $this->setPrimaryKey('pwdResetId');
        $this->addBehavior('Timestamp');
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
            ->email('pwdResetEmail')
            ->requirePresence('pwdResetEmail', 'create')
            ->notEmptyString('pwdResetEmail');

        $validator
            ->scalar('pwdResetSelector')
            ->maxLength('pwdResetSelector', 255)
            ->requirePresence('pwdResetSelector', 'create')
            ->notEmptyString('pwdResetSelector');

        $validator
            ->scalar('pwdResetToken')
            ->requirePresence('pwdResetToken', 'create')
            ->notEmptyString('pwdResetToken');

        $validator
            ->scalar('pwdResetExpires')
            ->requirePresence('pwdResetExpires', 'create')
            ->notEmptyString('pwdResetExpires');

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
        $rules->add($rules->isUnique(['pwdResetEmail']), ['errorField' => 'pwdResetEmail']);

        return $rules;
    }
}
