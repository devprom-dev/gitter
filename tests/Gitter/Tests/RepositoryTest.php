use Gitter\Statitics\StatiticsInterface;
    public function tearDown ()
    {
        \Mockery::close();
    }

    public function testIsNamesCorrect()
    {
        $a = $this->client->createRepository(self::$tmpdir . '/reponame');
        $b = $this->client->createRepository(self::$tmpdir . '/another-repo-name/');

        $this->assertEquals("reponame", $a->getName());
        $this->assertEquals("another-repo-name", $b->getName());
    }

    public function testIsAddingSingleStatistics ()
    {
        $statisticsMock = \Mockery::mock('Gitter\Statistics\StatiticsInterface');
        $statisticsMock->shouldReceive('sortCommits')->once();
        
        $repo = $this->client->createRepository(self::$tmpdir . '/teststatsrepo');
        $repo->addStatistics($statisticsMock);
        $repo->setCommitsHaveBeenParsed(true);

        $this->assertEquals(
            array(strtolower(get_class($statisticsMock)) => $statisticsMock),
            $repo->getStatistics(),
            'Failed to add single statistics'
        );
    }
