<?php

namespace Redmine\Tests;

use Redmine\Fixtures\MockClient as TestUrlClient;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestUrlClient
     */
    private $client;

    public function setup()
    {
        $this->client = new TestUrlClient('http://test.local', 'asdf');
    }

    public function testAttachment()
    {
        /** @var \Redmine\Api\Attachment $api */
        $api = $this->client->api('attachment');
        $res = $api->show(1);
        $this->assertEquals($res['path'], '/attachments/1.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->upload('asdf');
        $this->assertEquals($res['path'], '/uploads.json');
        $this->assertEquals($res['method'], 'POST');
    }

    public function testCustomFields()
    {
        /** @var \Redmine\Api\CustomField $api */
        $api = $this->client->api('custom_fields');
        $res = $api->all();
        $this->assertEquals($res['path'], '/custom_fields.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testGroup()
    {
        /** @var \Redmine\Api\Group $api */
        $api = $this->client->api('group');
        $res = $api->create(array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/groups.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->all();
        $this->assertEquals($res['path'], '/groups.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/groups/1.json?');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/groups/1.xml');
        $this->assertEquals($res['method'], 'DELETE');

        $res = $api->addUser(1, 1);
        $this->assertEquals($res['path'], '/groups/1/users.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->removeUser(1, 1);
        $this->assertEquals($res['path'], '/groups/1/users/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testIssue()
    {
        /** @var \Redmine\Api\Issue $api */
        $api = $this->client->api('issue');
        $res = $api->create(array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/issues.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/issues/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all();
        $this->assertEquals($res['path'], '/issues.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/issues/1.json?');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/issues/1.xml');
        $this->assertEquals($res['method'], 'DELETE');

        // $res = $api->setIssueStatus(1, 'asdf');
        // $this->assertEquals($res, array('path' => '/issues/1.xml', 'method' => 'DELETE'));

        $res = $api->addNoteToIssue(1, 'asdf');
        $this->assertEquals($res['path'], '/issues/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->attach(1, array('asdf'));
        $this->assertEquals($res['path'], '/issues/1.json');
        $this->assertEquals($res['method'], 'PUT');
    }

    public function testIssueCategory()
    {
        /** @var \Redmine\Api\IssueCategory $api */
        $api = $this->client->api('issue_category');
        $res = $api->create('testProject', array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects/testProject/issue_categories.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/issue_categories/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all('testProject');
        $this->assertEquals($res['path'], '/projects/testProject/issue_categories.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/issue_categories/1.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/issue_categories/1.xml?');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testIssuePriority()
    {
        /** @var \Redmine\Api\IssuePriority $api */
        $api = $this->client->api('issue_priority');
        $res = $api->all();
        $this->assertEquals($res['path'], '/enumerations/issue_priorities.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testIssueRelation()
    {
        /** @var \Redmine\Api\IssueRelation $api */
        $api = $this->client->api('issue_relation');
        $res = $api->all(1);
        $this->assertEquals($res['path'], '/issues/1/relations.json');
        $this->assertEquals($res['method'], 'GET');

        // $res = $api->show(1);
        // $this->assertEquals($res, array('path' => '/relations/1.json', 'method' => 'GET'));

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/relations/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testIssueStatus()
    {
        /** @var \Redmine\Api\IssueStatus $api */
        $api = $this->client->api('issue_status');
        $res = $api->all();
        $this->assertEquals($res['path'], '/issue_statuses.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testMembership()
    {
        /** @var \Redmine\Api\Membership $api */
        $api = $this->client->api('membership');
        $res = $api->create('testProject', array(
            'user_id' => 1,
            'role_ids' => array(1),
        ));
        $this->assertEquals($res['path'], '/projects/testProject/memberships.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array(
            'user_id' => 1,
            'role_ids' => array(1),
        ));
        $this->assertEquals($res['path'], '/memberships/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all('testProject');
        $this->assertEquals($res['path'], '/projects/testProject/memberships.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/memberships/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testNews()
    {
        /** @var \Redmine\Api\News $api */
        $api = $this->client->api('news');
        $res = $api->all();
        $this->assertEquals($res['path'], '/news.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->all('testProject');
        $this->assertEquals($res['path'], '/projects/testProject/news.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testProject()
    {
        /** @var \Redmine\Api\Project $api */
        $api = $this->client->api('project');
        $res = $api->create(array(
            'name' => 'asdf',
            'identifier' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all();
        $this->assertEquals($res['path'], '/projects.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/projects/1.json?include=trackers,issue_categories,attachments,relations');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/projects/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testQuery()
    {
        /** @var \Redmine\Api\Query $api */
        $api = $this->client->api('query');
        $res = $api->all();
        $this->assertEquals($res['path'], '/queries.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testRole()
    {
        /** @var \Redmine\Api\Role $api */
        $api = $this->client->api('role');
        $res = $api->all();
        $this->assertEquals($res['path'], '/roles.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/roles/1.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testTimeEntry()
    {
        /** @var \Redmine\Api\TimeEntry $api */
        $api = $this->client->api('time_entry');
        $res = $api->create(array(
            'issue_id' => 1,
            'hours' => 12,
        ));
        $this->assertEquals($res['path'], '/time_entries.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array());
        $this->assertEquals($res['path'], '/time_entries/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all();
        $this->assertEquals($res['path'], '/time_entries.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/time_entries/1.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/time_entries/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testTimeEntryActivity()
    {
        /** @var \Redmine\Api\TimeEntryActivity $api */
        $api = $this->client->api('time_entry_activity');
        $res = $api->all();
        $this->assertEquals($res['path'], '/enumerations/time_entry_activities.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testTracker()
    {
        /** @var \Redmine\Api\Tracker $api */
        $api = $this->client->api('tracker');
        $res = $api->all();
        $this->assertEquals($res['path'], '/trackers.json');
        $this->assertEquals($res['method'], 'GET');
    }

    public function testUser()
    {
        /** @var \Redmine\Api\User $api */
        $api = $this->client->api('user');
        $res = $api->create(array(
            'login' => 'asdf',
            'lastname' => 'asdf',
            'firstname' => 'asdf',
            'mail' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/users.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array());
        $this->assertEquals($res['path'], '/users/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all();
        $this->assertEquals($res['path'], '/users.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/users/1.json?include='.urlencode('memberships,groups'));
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1, array('include' => array('memberships', 'groups')));
        $this->assertEquals($res['path'], '/users/1.json?include='.urlencode('memberships,groups'));
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1, array('include' => array('memberships', 'groups', 'parameter1')));
        $this->assertEquals($res['path'], '/users/1.json?include='.urlencode('memberships,groups,parameter1'));
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1, array('include' => array('parameter1', 'memberships', 'groups')));
        $this->assertEquals($res['path'], '/users/1.json?include='.urlencode('parameter1,memberships,groups'));
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/users/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testVersion()
    {
        /** @var \Redmine\Api\Version $api */
        $api = $this->client->api('version');
        $res = $api->create('testProject', array(
            'name' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects/testProject/versions.xml');
        $this->assertEquals($res['method'], 'POST');

        $res = $api->update(1, array());
        $this->assertEquals($res['path'], '/versions/1.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all('testProject');
        $this->assertEquals($res['path'], '/projects/testProject/versions.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show(1);
        $this->assertEquals($res['path'], '/versions/1.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove(1);
        $this->assertEquals($res['path'], '/versions/1.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }

    public function testWiki()
    {
        /** @var \Redmine\Api\Wiki $api */
        $api = $this->client->api('wiki');
        $res = $api->create('testProject', 'about', array(
            'text' => 'asdf',
            'comments' => 'asdf',
            'version' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects/testProject/wiki/about.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->update('testProject', 'about', array(
            'text' => 'asdf',
            'comments' => 'asdf',
            'version' => 'asdf',
        ));
        $this->assertEquals($res['path'], '/projects/testProject/wiki/about.xml');
        $this->assertEquals($res['method'], 'PUT');

        $res = $api->all('testProject');
        $this->assertEquals($res['path'], '/projects/testProject/wiki/index.json');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show('testProject', 'about');
        $this->assertEquals($res['path'], '/projects/testProject/wiki/about.json?include=attachments');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->show('testProject', 'about', 'v1');
        $this->assertEquals($res['path'], '/projects/testProject/wiki/about/v1.json?include=attachments');
        $this->assertEquals($res['method'], 'GET');

        $res = $api->remove('testProject', 'about');
        $this->assertEquals($res['path'], '/projects/testProject/wiki/about.xml');
        $this->assertEquals($res['method'], 'DELETE');
    }
}
