<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BudgetsFixture
 */
class BudgetsFixture extends TestFixture
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
                'category_id' => 1,
                'amount_limit' => 1.5,
                'quarter' => 1,
                'year' => 1,
            ],
        ];
        parent::init();
    }
}
