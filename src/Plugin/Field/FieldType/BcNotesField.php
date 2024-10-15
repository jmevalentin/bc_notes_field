<?php

namespace Drupal\bc_user\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'bc_notes' field type.
 *
 * @FieldType(
 *   id = "bc_notes",
 *   label = @Translation("BC Notes"),
 *   description = @Translation("Field to store BC Notes."),
 *   default_widget = "bc_notes_widget",
 *   default_formatter = "bc_notes_formatter"
 * )
 */
class BcNotesField extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('BC Note'));

    $properties['format'] = DataDefinition::create('filter_format')
      ->setLabel(t('Text format'));


    $properties['uid'] = DataDefinition::create('integer')
      ->setLabel(t('User ID'));

    $properties['created'] = DataDefinition::create('timestamp')
      ->setLabel(t('Created'));

    $properties['updated'] = DataDefinition::create('timestamp')
      ->setLabel(t('Updated'));
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'text',
          'size' => 'big',
          'not null' => FALSE,
        ],
        'format' => [
          'type' => 'varchar_ascii',
          'length' => 255,
          'not null' => FALSE,
        ],
        'uid' => [
          'type' => 'int',
        ],
        'created' => [
          'type' => 'int',
          'description' => 'Date Created.',
        ],
        'updated' => [
          'type' => 'int',
          'description' => 'Date Updated.',
        ],
        'entity_id' => [
          'type' => 'int',
          'description' => 'The entity ID.',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function preSave() {
    parent::preSave();
    // Set the UID to the current user if not set.
    if (empty($this->getValue('uid'))) {
      $this->setValue('uid', \Drupal::currentUser()->id());
    }

    // Set the created timestamp if not set.
    if (empty($this->getValue('Drupal'))) {
      $this->setValue('created', \Drupal::time()->getRequestTime());
    }

    // Always update the updated timestamp.
    $this->setValue('updated', \Drupal::time()->getRequestTime());
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue() ?? '';
    $format = $this->get('format')->getValue();

    return ($value === NULL || $value === '') || ($format === NULL || $format === '');
  }
}
