<?php

/**
 * This is the simplest possible uni test that will pass
 */

/**
 * Advanced testcase lets us use a load of DB-specific stuff so that we can write data, test it happened OK,
 * then have the DB wiped automatically. There are a few extra methods in there too, so it's worth reading the
 * docs.
 *
 * http://docs.moodle.org/dev/PHPUnit_integration#advanced_testcase
 */
class database_test extends advanced_testcase {

    /**
     * The function mut start with test_ or else it will be ignored. This allows you to have other methods
     * which are not run by PHPUnit, which you can use as helpers.
     */
    public function test_db_read_write_works() {
        global $DB;

        $this->resetAfterTest(true); // reset all changes automatically after this test

        $user= new stdClass();
        $user->email = 'new@user.com';
        $user->username = 'newuser';
        $DB->insert_record('user', $user);

        $this->assertNotEmpty($DB->get_record('user', array('email' => 'new@user.com')));
    }

    /**
     * The function mut start with test_ or else it will be ignored. This allows you to have other methods
     * which are not run by PHPUnit, which you can use as helpers.
     */
    public function test_db_is_not_messed_with() {
        global $DB;

        // $this->resetAfterTest(true); // without this, any changes to the DB will cause a failure

        $user = new stdClass();
        $user->email = 'new@user.com';
        $user->username = 'newuser';
        $DB->insert_record('user', $user);

        $this->assertNotEmpty($DB->get_record('user', array('email' => 'new@user.com')));
    }
}