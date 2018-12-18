<?php

namespace Tests\Feature;

use CloudCreativity\LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase as BaseTestCase;

/**
 * Class JsonApiTestCase
 * @package Tests\Feature
 *
 * Intermediate" class using MakesJsonApiRequests trait is needed
 * in order to allow child classes to override attributes such as
 * $api or $resourceType
 */
abstract class JsonApiTestCase extends BaseTestCase
{
    use MakesJsonApiRequests;

    public function setUp()
    {
        parent::setUp();
        $this->seed('TestingDatabaseSeeder');
    }
}
