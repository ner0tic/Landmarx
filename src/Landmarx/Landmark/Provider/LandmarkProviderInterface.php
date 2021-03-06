<?php

namespace Landmarx\Landmark\Provider;

interface MenuProviderInterface {
  /**
   * Retrieves a landmark by its name
   *
   * @param string $name
   * @param array  $options
   *
   * @return \Landmarx\Landmark\ItemInterface
   * @throws \InvalidArgumentException if the menu does not exists
   */
  public function get($name, array $options = array());

  /**
   * Checks whether a menu exists in this provider
   *
   * @param string $name
   * @param array  $options
   *
   * @return boolean
   */
  public function has($name, array $options = array());
}