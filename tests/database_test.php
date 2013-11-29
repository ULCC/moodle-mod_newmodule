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
     * Use to test failure by commenting resetAfterTest(). If you are doing something where it is important that it has no side effects, then
     * leave out reset_after_test() to get notified.
     */
    public function test_db_is_not_messed_with() {
        global $DB;

        $this->resetAfterTest(true); // without this, any changes to the DB will cause a failure

        $user = new stdClass();
        $user->email = 'new@user.com';
        $user->username = 'newuser';
        $DB->insert_record('user', $user);

        $this->assertNotEmpty($DB->get_record('user', array('email' => 'new@user.com')));
    }

    /**
     * The built in data generator has a few utility methods that save a lot of time.
     */
    public function test_core_data_generator() {
        global $DB;

        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();

        $user = $generator->create_user();

        // Admin, guest, and the new one.
        $this->assertEquals(3, $DB->count_records('user'));

    }

    /**
     * Each plugin can define its own generator, which make code easy to reuse.
     * Make/find these in plugin/tests/generator/lib.php
     */
    public function test_plugin_data_generator() {
        global $DB;

        $this->resetAfterTest(true);

        $generator = $this->getDataGenerator();
        /**
         * @var mod_assign_generator $assign_generator
         */
        $assign_generator = $generator->get_plugin_generator('mod_assign');

        $course = $generator->create_course();

        // Needs a course as a minimum. All other details are auto-generated.
        $assign = new stdClass();
        $assign->course = $course->id;
        $full_assign = $assign_generator->create_instance($assign);

        $this->assertEquals(1, $DB->count_records('assign'));
    }
}