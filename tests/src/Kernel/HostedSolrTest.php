<?php

namespace Drupal\Tests\hosted_solr\Kernel;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Kernel\SearchApiSolrTest;

/**
 * Tests index and search capabilities using the Solr search backend.
 *
 * @group hosted_solr
 */
class HostedSolrTest extends SearchApiSolrTest {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'hosted_solr',
    'hosted_solr_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function installConfigs() {
    parent::installConfigs();

    $this->installConfig([
      'hosted_solr',
      'hosted_solr_test',
    ]);

    // Swap the connector.
    HostedSolrTestConnector::adjustBackendConfig('search_api.server.solr_search_server');
  }

  /**
   * {@inheritdoc}
   */
  public function testConfigGeneration(array $files = []) {
    self::markTestSkipped('Config generation tests are skipped as Hosted Solr uses the jump start config sets.');
  }

}
