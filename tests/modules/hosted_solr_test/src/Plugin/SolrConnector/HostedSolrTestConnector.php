<?php

namespace Drupal\hosted_solr_test\Plugin\SolrConnector;

use Drupal\hosted_solr\Plugin\SolrConnector\HostedSolrConnector;
use Drupal\search_api_solr\Utility\Utility;
use Solarium\Core\Client\Endpoint;
use Solarium\Core\Client\Request;
use Solarium\Core\Client\Response;
use Solarium\Core\Query\QueryInterface;
use Solarium\Core\Query\Result\Result;

defined('HOSTED_SOLR_HOST') || define('HOSTED_SOLR_HOST', getenv('HOSTED_SOLR_HOST') ?: '');
defined('HOSTED_SOLR_USER') || define('HOSTED_SOLR_USER', getenv('HOSTED_SOLR_USER') ?: '');
defined('HOSTED_SOLR_PASSWORD') || define('HOSTED_SOLR_PASSWORD', getenv('HOSTED_SOLR_PASSWORD') ?: '');

/**
 * Hosted Solr test connector.
 *
 * @SolrConnector(
 *   id = "hosted_solr_test",
 *   label = @Translation("Hosted Solr Test"),
 *   description = @Translation("Index items using the Hosted Solr service.")
 * )
 */
class HostedSolrTestConnector extends HostedSolrConnector {

  /**
   * The Solarium query.
   *
   * @var \Solarium\Core\Query\QueryInterface
   */
  protected static $query;

  /**
   * The Solarium request.
   *
   * @var \Solarium\Core\Client\Request
   */
  protected static $request;

  /**
   * Whether to intercept the query/request or not.
   *
   * @var bool
   */
  protected $intercept = FALSE;

  /**
   * {@inheritdoc}
   */
  public function execute(QueryInterface $query, Endpoint $endpoint = NULL) {
    self::$query = $query;

    if ($this->intercept) {
      /** @var \Solarium\Core\Query\AbstractQuery $query */
      return new Result($query, new Response(''));
    }

    return parent::execute($query, $endpoint);
  }

  /**
   * {@inheritdoc}
   */
  public function executeRequest(Request $request, Endpoint $endpoint = NULL) {
    self::$request = $request;

    if ($this->intercept) {
      return new Response('');
    }

    return parent::executeRequest($request, $endpoint);
  }

  /**
   * Gets the Solarium query.
   */
  public function getQuery() {
    return self::$query;
  }

  /**
   * Gets the Solarium request.
   */
  public function getRequest() {
    return self::$request;
  }

  /**
   * Gets the Solarium request parameters.
   */
  public function getRequestParams() {
    return Utility::parseRequestParams(self::$request);
  }

  /**
   * Sets the intercept property.
   */
  public function setIntercept(bool $intercept) {
    $this->intercept = $intercept;
  }

  public static function adjustBackendConfig($config_name) {
    $config_factory = \Drupal::configFactory();
    $config = $config_factory->getEditable($config_name);
    $backend_config = $config->get('backend_config');
    $config->set('backend_config',
      [
        'connector' => 'hosted_solr_test',
        'connector_config' => [
          'scheme' => 'https',
          'host' => HOSTED_SOLR_HOST,
          'port' => 443,
          'path' => '/' . HOSTED_SOLR_USER,
          'core' => 'core',
          'username' => HOSTED_SOLR_USER,
          'password' => HOSTED_SOLR_PASSWORD,
        ] + $backend_config['connector_config'],
      ] + $backend_config)
      ->save(TRUE);

    $search_api_server_storage = \Drupal::entityTypeManager()->getStorage('search_api_server');
    $search_api_server_storage->resetCache();

    $search_api_index_storage = \Drupal::entityTypeManager()->getStorage('search_api_index');
    $search_api_index_storage->resetCache();
  }
}
