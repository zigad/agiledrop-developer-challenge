<?php

namespace Drupal\remaining_time\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\remaining_time\Service\RemainingTimeService;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "remaining_time",
 *   admin_label = @Translation("Remaining time"),
 * )
 */
class RemainingTimeBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $service = \Drupal::service('remaining_time.event_status');

    $nodeId = \Drupal::routeMatch()->getRawParameter('node'); //node ID iz urlja
    $node = Node::load($nodeId);
    $eventStartDate = $node->get('field_event_date')->value;
    $data = $service->eventStatus($eventStartDate);

    return array(
     '#markup' => "<h3>{$data}</h3>",
      '#cache' => array(
        'max-age' => 0,
        ),
    );
  }
  
  /**
  * {@inheritdoc}
  */
  public function getCacheMaxAge() {
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['remaining_time_settings'] = $form_state->getValue('remaining_time_settings');
  }
}