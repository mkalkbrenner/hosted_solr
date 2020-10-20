<?php

namespace Drupal\Tests\hosted_solr\Functional;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Functional\ViewsTest as SearchApiSolrViewsTest;

/**
 * Tests the Views integration of the Search API.
 *
 * @group hosted_solr
 */
class ViewsTest extends SearchApiSolrViewsTest {

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
  protected function adjustBackendConfig() {
    // Swap the connector.
    HostedSolrTestConnector::adjustBackendConfig('search_api.server.solr_search_server');
  }

}
