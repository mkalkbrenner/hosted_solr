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

  /**
   * {@inheritdoc}
   */
  protected function configureBackendAndSave(array $edit) {
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Please configure the selected backend.');

    $edit += [
      'backend_config[connector]' => 'hosted_solr',
    ];
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('Please configure the selected Solr connector.');

    $edit += [
      'backend_config[connector_config][host]' => 'localhost',
      'backend_config[connector_config][auth][username]' => HOSTED_SOLR_USER,
      'backend_config[connector_config][auth][password]' => HOSTED_SOLR_PASSWORD,
    ];
    $this->submitForm($edit, 'Save');

    $this->assertSession()->pageTextContains('The server was successfully saved.');
    $this->assertSession()->addressEquals('admin/config/search/search-api/server/' . $this->serverId);
    $this->assertSession()->pageTextContains('The Solr server could not be reached or is protected by your service provider.');

    // Go back in and configure Solr.
    $edit_path = 'admin/config/search/search-api/server/' . $this->serverId . '/edit';
    $this->drupalGet($edit_path);
    $edit['backend_config[connector_config][host]'] = HOSTED_SOLR_HOST;
    $this->submitForm($edit, 'Save');
    $this->assertSession()->pageTextContains('The Solr server could be reached.');
  }

}
