<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RelatedsTable;
use App\Model\Table\VideosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VideosTable Test Case
 */
class VideosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VideosTable
     */
    protected $Videos;

    /**
     * Test subject
     *
     * @var \App\Model\Table\RelatedsTable
     */
    protected $Relateds;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Videos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Videos') ? [] : ['className' => VideosTable::class];
        $this->Videos = $this->getTableLocator()->get('Videos', $config);

        $config = $this->getTableLocator()->exists('Relateds') ? [] : ['className' => RelatedsTable::class];
        $this->Relateds = $this->getTableLocator()->get('Relateds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Videos);

        parent::tearDown();
    }

    /**
     * testFindCount Method
     *
     * @return void
     * @uses \App\Model\Table\VideosTable::validationDefault()
     */
    public function testFindCount(): void
    {
        $this->assertEquals(10, $this->Videos->find()->count());
    }

    /**
     * testAdd Method
     *
     * @return void
     * @uses \App\Model\Table\VideosTable::validationDefault()
     */
    public function testAdd(): void
    {
        $data = [
            'videokey' => 'videokey',
            'title' => 'title',
        ];
        $video = $this->Videos->newEntity($data);

        $this->Videos->save($video);
        $this->assertNotEmpty($video->id);

        $this->assertEquals(11, $this->Videos->find()->count());
    }

    /**
     * testDelete Method
     *
     * @return void
     * @uses \App\Model\Table\VideosTable::validationDefault()
     */
    public function testDelete(): void
    {
        $video = $this->Videos->get(1);
        $this->Videos->delete($video);

        $this->assertEquals(9, $this->Videos->find()->count());
    }

    /**
     * testAddRelated Method
     *
     * @return void
     * @uses \App\Model\Table\VideosTable::validationDefault()
     */
    public function testAddRelated(): void
    {
        /** @var \App\Model\Entity\Video $video */
        $video = $this->Videos->get(1);
        $video = $this->Videos->patchEntity($video, [
            'relateds' => [
                '_ids' => [2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
        ]);

        $this->Videos->save($video);

        $video = $this->Videos->find()
            ->where(['id' => 1])
            ->first();

        $this->assertEquals(9, $video->related_count);

        $video = $this->Videos->patchEntity($video, [
            'relateds' => [
                '_ids' => [2, 3, 4],
            ],
        ]);

        $this->Videos->save($video);

        $video = $this->Videos->get(1, ['contain' => ['Relateds']]);

        $this->assertEquals(3, $video->related_count);
        $this->assertEquals(3, count($video->relateds));
    }

    /**
     * testDeleteRelated Method
     *
     * @return void
     * @uses \App\Model\Table\VideosTable::validationDefault()
     */
    public function testDeleteRelated(): void
    {
        /** @var \App\Model\Entity\Video $video */
        $video = $this->Videos->get(1);
        $video = $this->Videos->patchEntity($video, [
            'relateds' => [
                '_ids' => [2, 3, 4, 5],
            ],
        ]);

        $this->Videos->save($video);

        $video = $this->Videos->find()
            ->where(['id' => 1])
            ->first();

        $this->assertEquals(4, $video->related_count);

        $RelatedsVideos = $this->fetchTable('RelatedsVideos');
        $this->assertEquals(4, $RelatedsVideos->find()->where(['video_id' => 1])->count());

        $this->Videos->delete($this->Relateds->get(2));

        $video = $this->Relateds->find()
            ->where(['id' => 1])
            ->first();

        /**
         * Test Not Pass
         */
        $this->assertEquals(3, $RelatedsVideos->find()->where(['video_id' => 1])->count());
        $this->assertEquals(3, $video->related_count);

        $video = $this->Videos->find()
            ->where(['id' => 2])
            ->first();

        $this->assertNull($video);

        $video = $this->Videos->get(1, ['contain' => ['Relateds']]);

        /**
         * Test Not Pass
         */
        $this->assertEquals(3, count($video->relateds));
        $this->assertEquals(3, $video->get('related_count'));
    }
}
