<?php

namespace Drupal\d8_demo_2\Access;

use Drupal\Core\Session\AccountProxy;
use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

class NodeCreatorCheck implements AccessInterface {
  
  private $account;

  public function __construct(AccountProxy $account) {
  	$this->account = $account;
  }

  public function access(NodeInterface $node1, NodeInterface $node2) {
  	//kint($node->getOwnerId());
  	//kint($this->account->id());
    if($node1->getOwnerId() === $this->account->id()) {
      return AccessResult::allowed();
    }
    else {
      return AccessResult::forbidden();
    }
  }
}