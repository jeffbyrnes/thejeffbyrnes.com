<?php
/**
 *
 * ThinkUp/webapp/plugins/twitter/tests/TestOfTwitterAuthController.php
 *
 * Copyright (c) 2009-2011 Gina Trapani
 *
 * LICENSE:
 *
 * This file is part of ThinkUp (http://thinkupapp.com).
 *
 * ThinkUp is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * ThinkUp is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with ThinkUp.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Test of TwitterAuthController
 *
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2009-2011 Gina Trapani
 * @author Gina Trapani <ginatrapani[at]gmail[dot]com>
 *
 */
require_once 'tests/init.tests.php';
require_once THINKUP_ROOT_PATH.'webapp/_lib/extlib/simpletest/autorun.php';
require_once THINKUP_ROOT_PATH.'webapp/config.inc.php';
if (!class_exists('twitterOAuth')) {
    require_once THINKUP_ROOT_PATH.'webapp/plugins/twitter/tests/classes/mock.TwitterOAuth.php';
}
require_once THINKUP_ROOT_PATH.'webapp/plugins/twitter/model/class.TwitterOAuthThinkUp.php';
require_once THINKUP_ROOT_PATH.'webapp/plugins/twitter/model/class.TwitterAPIAccessorOAuth.php';
require_once THINKUP_ROOT_PATH.'webapp/plugins/twitter/model/class.TwitterPlugin.php';
require_once THINKUP_ROOT_PATH.'webapp/plugins/twitter/controller/class.TwitterAuthController.php';

class TestOfTwitterAuthController extends ThinkUpUnitTestCase {

    public function setUp(){
        parent::setUp();
    }

    public function testConstructor() {
        $controller = new TwitterAuthController(true);
        $this->assertTrue(isset($controller));
    }
    //Test not logged in
    public function testNotLoggedIn() {
        $controller = new TwitterAuthController(true);
        $results = $controller->go();
        $v_mgr = $controller->getViewManager();
        $config = Config::getInstance();
        $this->assertEqual('You must <a href="'.$config->getValue('site_root_path').
        'session/login.php">log in</a> to do this.', $v_mgr->getTemplateDataItem('error_msg'));
    }

    //Test no params
    public function testLoggedInMissingParams() {
        $this->simulateLogin('me@example.com');
        $controller = new TwitterAuthController(true);
        $results = $controller->go();

        $v_mgr = $controller->getViewManager();
        $this->assertEqual('Secret token not set.', $v_mgr->getTemplateDataItem('info_msg'), "Info msg set");
    }

    //Test Session param but no Get param
    public function testLoggedInMissingToken() {
        $this->simulateLogin('me@example.com');
        SessionCache::put('oauth_request_token_secret', 'XXX');
        $controller = new TwitterAuthController(true);
        $results = $controller->go();

        $v_mgr = $controller->getViewManager();
        $this->assertEqual('No OAuth token specified.', $v_mgr->getTemplateDataItem('info_msg'), "Info msg set");
    }

    //Test Session param but no Get param
    public function testLoggedInMissingSessionWithGet() {
        $this->simulateLogin('me@example.com');
        $_GET['oauth_token'] = 'XXX';
        $controller = new TwitterAuthController(true);
        $results = $controller->go();

        $v_mgr = $controller->getViewManager();
        $this->assertEqual('Secret token not set.', $v_mgr->getTemplateDataItem('info_msg'), "Info msg set");
    }

    public function testLoggedInAllParams() {
        $this->simulateLogin('me@example.com');
        $_GET['oauth_token'] = 'XXX';
        SessionCache::put('oauth_request_token_secret', 'XXX');

        $owner_builder = FixtureBuilder::build('owners', array('id'=>'10', 'email'=>'me@example.com'));
        $namespace = OptionDAO::PLUGIN_OPTIONS . '-1';
        $plugn_opt_builder1 = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'oauth_consumer_key', 'option_value'=>'XXX'));
        $plugn_opt_builder2 = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'oauth_consumer_secret', 'option_value'=>'YYY'));
        $plugn_opt_builder3 = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'num_twitter_errors', 'option_value'=>'5'));
        $plugn_opt_builder4 = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'max_api_calls_per_crawl', 'option_value'=>'350'));

        $controller = new TwitterAuthController(true);
        $results = $controller->go();

        //sleep(100);
        $v_mgr = $controller->getViewManager();
        $this->assertEqual('Success! dougw on Twitter has been added to ThinkUp!',
        $v_mgr->getTemplateDataItem('success_msg'));
    }

    public function testLoggedInAllParamsServiceUserExists() {
        $this->simulateLogin('me@example.com');
        $_GET['oauth_token'] = 'XXX';
        SessionCache::put('oauth_request_token_secret', 'XXX');

        $builders[] = FixtureBuilder::build('owners', array('id'=>'10', 'email'=>'me@example.com'));
        $namespace = OptionDAO::PLUGIN_OPTIONS . '-1';
        $builders[] = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'oauth_consumer_key', 'option_value'=>'XXX'));
        $builders[] = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'oauth_consumer_secret', 'option_value'=>'YYY'));
        $builders[] = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'num_twitter_errors', 'option_value'=>'5'));
        $builders[] = FixtureBuilder::build('options', array('namespace'=>$namespace,
        'option_name'=>'max_api_calls_per_crawl', 'option_value'=>'350'));
        $builders[] = FixtureBuilder::build('instances', array('network_user_id'=>'1401881',
        'network_username'=>'dougw', 'network'=>'twitter'));
        $builders[] = FixtureBuilder::build('instances_twitter', array('last_page_fetched_replies'=>1));
        $builders[] = FixtureBuilder::build('owner_instances', array('instance_id'=>1, 'owner_id'=>10));

        $controller = new TwitterAuthController(true);
        $results = $controller->go();

        $v_mgr = $controller->getViewManager();
        $this->debug($results);
        $this->assertEqual('dougw on Twitter is already set up in ThinkUp! To add a different Twitter account, log '.
        'out of Twitter.com in your browser and authorize ThinkUp again.', $v_mgr->getTemplateDataItem('success_msg'));
    }
}
