<?php

namespace Drupal\Tests\hosted_solr\Functional;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Functional\FacetsTest as SearchApiSolrFacetsTest;

/**
 * Tests the facets functionality using the Solr backend.
 *
 * @group hosted_solr
 */
class FacetsTest extends SearchApiSolrFacetsTest {

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
