<?php
/**
 * @file
 * DrupalDatabaseWrapper implementation.
 */

namespace Drupal\objectify\Database;

/**
 * Class DrupalDatabaseWrapper
 * @package Drupal\objectify
 *
 * @method \SelectQuery select($table, $alias = NULL, array $options = array())
 * @method \InsertQuery insert($table, array $options = array())
 * @method \MergeQuery merge($table, array $options = array())
 * @method \UpdateQuery update($table, array $options = array())
 * @method \DeleteQuery delete($table, array $options = array())
 * @method \TruncateQuery truncate($table, array $options = array())
 */
class DrupalDatabaseWrapper {

  /**
   * Database identifier to send methods to.
   *
   * @var string
   */
  protected $database = 'default';

  /**
   * Forward method calls to the default database.
   *
   * @param string $name
   * @param array $arguments
   */
  public function __call($name, $arguments) {
    return call_user_func_array([\Database::getConnection($this->database), $name], $arguments);
  }

  /**
   * Setter for $database.
   *
   * @param string $database
   */
  public function setDatabase($database) {
    $this->database = $database;
  }

  /**
   * Getter for $database.
   *
   * @return string
   */
  public function getDatabase() {
    return $this->database;
  }

}
