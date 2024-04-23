<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Foto Model
 *
 * @property \App\Model\Table\AlbumTable&\Cake\ORM\Association\BelongsTo $Album
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\KomentarTable&\Cake\ORM\Association\HasMany $Komentar
 * @property \App\Model\Table\LikeTable&\Cake\ORM\Association\HasMany $Like
 *
 * @method \App\Model\Entity\Foto newEmptyEntity()
 * @method \App\Model\Entity\Foto newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Foto> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Foto get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Foto findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Foto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Foto> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Foto|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Foto saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Foto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Foto>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Foto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Foto> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Foto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Foto>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Foto>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Foto> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FotoTable extends Table
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

        $this->setTable('foto');
        $this->setDisplayField('judul');
        $this->setPrimaryKey('id');

        $this->belongsTo('Album', [
            'foreignKey' => 'album_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Komentar', [
            'foreignKey' => 'foto_id',
        ]);
        $this->hasMany('Likes', [
            'foreignKey' => 'foto_id',
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
            ->scalar('judul')
            ->maxLength('judul', 255)
            ->requirePresence('judul', 'create')
            ->notEmptyString('judul');

        $validator
            ->scalar('deskripsi')
            ->requirePresence('deskripsi', 'create')
            ->notEmptyString('deskripsi');

        $validator
            ->dateTime('tanggal_unggah')
            ->requirePresence('tanggal_unggah', 'create')
            ->notEmptyDateTime('tanggal_unggah');

        $validator
            ->scalar('lokasi_file')
            ->maxLength('lokasi_file', 255)
            ->requirePresence('lokasi_file', 'create')
            ->notEmptyFile('lokasi_file');

        $validator
            ->integer('album_id')
            ->notEmptyString('album_id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->allowEmptyFile('images')
            ->requirePresence('images','create')
            ->uploadedFile('images', [
                'types'=> [
                    'image/jpg',
                    'image/png',
                    'image/jpeg',
                ],
            ], 'The File Cannot Be innput Cause File Allowed is .jpg, .png and .jpeg');

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
        $rules->add($rules->existsIn(['album_id'], 'Album'), ['errorField' => 'album_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
