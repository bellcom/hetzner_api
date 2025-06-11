<?php

namespace Drupal\hetzner_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class HetznerSettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['hetzner_api.settings'];
  }

  public function getFormId() {
    return 'hetzner_api_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('hetzner_api.settings');

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hetzner API Key'),
      '#default_value' => $config->get('api_key'),
      '#required' => TRUE,
    ];

    $form['sync_link'] = [
      '#type' => 'link',
      '#title' => $this->t('Synkroniser nu'),
      '#url' => Url::fromRoute('hetzner_api.sync'),
      '#attributes' => ['class' => ['button']],
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hetzner_api.settings')
      ->set('api_key', $form_state->getValue('api_key'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
