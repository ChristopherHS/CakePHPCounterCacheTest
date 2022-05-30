<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VideosFixture
 */
class VideosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [];
        for ($i = 1; $i <= 10; $i++) {
            $this->records[] = [
                'id' => $i,
                'videokey' => 'videokey' . $i,
                'title' => 'Title ' . $i,
            ];
        }

        parent::init();
    }
}
