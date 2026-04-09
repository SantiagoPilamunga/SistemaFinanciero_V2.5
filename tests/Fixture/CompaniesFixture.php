<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompaniesFixture
 */
class CompaniesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'ruc' => 'Lorem ipsum dolor ',
                'budget_limit' => 1.5,
                'created' => '2026-03-30 21:30:36',
                'modified' => '2026-03-30 21:30:36',
            ],
        ];
        parent::init();
    }
}
