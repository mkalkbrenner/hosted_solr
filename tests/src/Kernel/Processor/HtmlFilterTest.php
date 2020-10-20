<?php

namespace Drupal\Tests\hosted_solr\Kernel\Processor;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Kernel\Processor\HtmlFilterTest as SearchApiSolrHtmlFilterTest;

/**
 * Tests usages of Solr payloads.
 *
 * @group hosted_solr
 *
 * @see \Drupal\search_api\Plugin\search_api\processor\HtmlFilter
 */
class HtmlFilterTest extends SearchApiSolrHtmlFilterTest {

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
