<?php

namespace Drupal\Tests\hosted_solr\Kernel\Processor;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Kernel\Processor\DoubleQuoteWorkaroundTest as SearchApiSolrDoubleQuoteWorkaroundTest;

/**
 * Tests the "Double Quote Workaround" processor.
 *
 * @group hosted_solr
 *
 * @see \Drupal\search_api_solr\Plugin\search_api\processor\DoubleQuoteWorkaround
 */
class DoubleQuoteWorkaroundTest extends SearchApiSolrDoubleQuoteWorkaroundTest {

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
  protected function enableSolrServer() {
    parent::enableSolrServer();

    // Swap the connector.
    HostedSolrTestConnector::adjustBackendConfig('search_api.server.solr_search_server');
  }

}
