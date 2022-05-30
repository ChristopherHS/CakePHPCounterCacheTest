<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RelatedsVideo Entity
 *
 * @property int $video_id
 * @property int $related_id
 *
 * @property \App\Model\Entity\Video $video
 * @property \App\Model\Entity\Related $related
 */
class RelatedsVideo extends Entity
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
    protected $_accessible = [
        'video' => true,
        'related' => true,
    ];
}
