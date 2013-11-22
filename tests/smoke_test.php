<?php

/**
 * This is the simplest possible uni test that will pass
 */

/**
 * We extend basic testcase, which gives us all of the PHPUnit stuff we need to do assertions, setup
 * and teardown. We do not need the database. If we did, we would extend advanced_testcase instead, which would
 * handle the automatic wiping of the tables (and take longer).
 */
class smoke_test extends basic_testcase {

    /**
     * The function mut start with test_ or else it will be ignored. This allows you to have other methods
     * which are not run by PHPUnit, which you can use as helpers.
     */
    public function test_it_works() {
        $this->assertTrue(true);
    }
}