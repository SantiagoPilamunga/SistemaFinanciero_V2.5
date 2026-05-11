<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomerMetricsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomerMetricsTable Test Case
 */
class CustomerMetricsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomerMetricsTable
     */
    protected $CustomerMetrics;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CustomerMetrics',
        'app.Departments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CustomerMetrics') ? [] : ['className' => CustomerMetricsTable::class];
        $this->CustomerMetrics = $this->getTableLocator()->get('CustomerMetrics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CustomerMetrics);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\CustomerMetricsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\CustomerMetricsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
