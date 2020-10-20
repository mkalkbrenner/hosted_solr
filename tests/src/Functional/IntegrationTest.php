<?php

namespace Drupal\Tests\hosted_solr\Functional;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Functional\IntegrationTest as SearchApiSolrIntegrationTest;

/**
 * Tests the overall functionality of the Search API framework and admin UI.
 *
 * @group hosted_solr
 */
class IntegrationTest extends SearchApiSolrIntegrationTest {

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
  public function setUp(): void {
    parent::setUp();

    // Swap the connector.
    HostedSolrTestConnector::adjustBackendConfig('search_api.server.solr_search_server');
  }

}
