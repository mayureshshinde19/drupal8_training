<?php

namespace Drupal\d8_demo_2\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'LatestNodeTitleBlock' block.
 *
 * @Block(
 * id = "latest_node_title_block",
 * admin_label = @Translation("Latest node title block"),
 * )
 */
class LatestNodeTitleBlock extends BlockBase implements ContainerFactoryPluginInterface {

	/**
	 * Drupal\Core\Database\Driver\mysql\Connection definition.
	 *
	 * @var \Drupal\Core\Database\Driver\mysql\Connection
	 */
	protected $database;
	/**
	 * Construct.
	 *
	 * @param array $configuration
	 *        	A configuration array containing information about the plugin instance.
	 * @param string $plugin_id
	 *        	The plugin_id for the plugin instance.
	 * @param string $plugin_definition
	 *        	The plugin implementation definition.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, AccountProxy $account) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->account = $account;
		$this->database = $database;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'database' ), $container->get ( 'current_user' ) );
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function build() {
		$build = [ ];
		kint ( $this->account );
		$result = $this->getData ();
		$build ['latest_node_title_block'] ['#markup'] = 'Implement LatestNodeTitleBlock<br>' . implode ( '|', $result ['title'] ) . $this->account->getEmail ();
		$build ['latest_node_title_block'] ['#cache'] = [
				'tags' => $result ['tags'],
				'contexts' => [
						'user'
				]
		] // auto placeholder the user context
;

		return $build;
	}
	public function getData() {
		$title = [ ];
		$tags = [ ];
		$query = $this->database->select ( 'node_field_data', 'nd' )->fields ( 'nd', [
				'nid',
				'title'
		] )->range ( 0, 3 );
		$result = $query->execute ();

		while ( $row = $result->fetchAssoc () ) {
			$title [] = $row ['title'];
			$tags [] = 'node:' . $row ['nid'];
		}
		return [
				'title' => $title,
				'tags' => $tags
		];
	}
}
