<?php

namespace Drupal\d8_demo_2\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

class D8DemoController implements ContainerInjectionInterface {
	private $account;
	public function __construct(AccountProxy $account) {
		$this->account = $account;
	}
	public function staticContent() {
		return [
				'#markup' => "Hello WOrld"
		];
	}
	public function dynamicContent($arg) {
		return [
				'#markup' => "Argument is " . $arg
		];
	}
	public function dynamicNode(NodeInterface $node1, NodeInterface $node2) {
		return [
				'#theme' => 'item_list',
				'#items' => [
						$node1->getTitle (),
						$node2->getTitle ()
				]
		];
	}
	public function nodeCreatorCheck(NodeInterface $node1, NodeInterface $node2) {
		// $account_id = \Drupal::service('current_user')->id();
		if ($node1->getOwnerId () === $this->account->id ()) {
			return AccessResult::allowed ();
		} else {
			return AccessResult::forbidden ();
		}

		// return AccessResult::forbidden();
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( current_user ) );
	}
}