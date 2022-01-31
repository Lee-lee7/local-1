<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\li\Controller;
class HelloController {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello! You can add here a photo of your cat'),
    );
  }
}

