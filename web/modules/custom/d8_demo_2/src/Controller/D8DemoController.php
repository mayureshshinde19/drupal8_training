<?php
namespace Drupal\d8_demo_2\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;

class D8DemoController {

  public function staticContent() {
  	return [
  	  '#markup' => "Hello WOrld"];
  }

  public function dynamicContent($arg) {
  	return [
  	  '#markup' => "Argument is ".$arg];
  }

  public function dynamicNode(NodeInterface $node1, NodeInterface $node2) {
  	return [
  	  '#theme' => 'item_list',
  	  '#items' => [
  	     $node1->getTitle(),
         $node2->getTitle(),
        ]
  	];
  }

  public function nodeCreatorCheck(NodeInterface $node1, NodeInterface $node2) {
    $account_id = \Drupal::service('current_user')->id();
    if($node1->getOwnerId() === $account_id) {
      return AccessResult::allowed();
    }
    else {
      return AccessResult::forbidden();
    }

    //return AccessResult::forbidden();
  }
}