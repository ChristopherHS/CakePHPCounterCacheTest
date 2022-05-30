<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\RelatedsVideo;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RelatedsVideos Model
 *
 * @property \App\Model\Table\VideosTable&\Cake\ORM\Association\BelongsTo $Videos
 * @property \App\Model\Table\RelatedsTable&\Cake\ORM\Association\BelongsTo $Relateds
 *
 * @method \App\Model\Entity\RelatedsVideo newEmptyEntity()
 * @method \App\Model\Entity\RelatedsVideo newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RelatedsVideo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RelatedsVideo get($primaryKey, $options = [])
 * @method \App\Model\Entity\RelatedsVideo findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RelatedsVideo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RelatedsVideo[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RelatedsVideo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelatedsVideo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RelatedsVideo[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RelatedsVideo[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RelatedsVideo[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RelatedsVideo[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RelatedsVideosTable extends Table
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

        $this->setTable('relateds_videos');
        $this->setDisplayField(['video_id', 'related_id']);
        $this->setPrimaryKey(['video_id', 'related_id']);

        $this->addBehavior('CounterCache', [
            'Videos' => [
                'related_count',
            ],
        ]);

        $this->belongsTo('Videos', [
            'foreignKey' => 'video_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Relateds', [
            'foreignKey' => 'related_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn('video_id', 'Videos'), ['errorField' => 'video_id']);
        $rules->add($rules->existsIn('related_id', 'Relateds'), ['errorField' => 'related_id']);

        return $rules;
    }
}
