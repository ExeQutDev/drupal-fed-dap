<?php

declare(strict_types=1);

namespace Drupal\fed_dap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure FED - Digital Analytics Program Government-wide Code settings for this site.
 */
final class FedDapConfigurationSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'fed_dap_fed_dap_configuration_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['fed_dap.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['header_group'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Details'),
        '#weight' => -50,
        '#collapsible' => false,
    ];
    $form['header_group']['header_desc'] = [
        '#markup' => $this->t('Federal Digital Analytics Program are provided in more detail a official website: <a href="https://digital.gov/guides/dap/">https://digital.gov/guides/dap/</a>'),
        '#weight' => -100,
    ];
    
    $form['base_param_group'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Core Parameters'),
        '#weight' => 1,
        '#collapsible' => false,
        '#description' => $this->t('<strong>Register with the DAP</strong><br />Any federal agency can sign up to use the Digital Analytics Program (DAP) web analytics tool.<br />Here’s how it works:<ol><li>Agencies define a DAP point of contact. If you don’t have an identified point of contact, email the DAP team at dap@gsa.gov.</li><li>The DAP team will send the agency point of contact a short registration form to register their agency, and work with them to implement the common page tag code.</li></li>The DAP team will provide implementation support, access to training, and other resources to the agency point of contact.</li></ul><br /><br />For more information please reference: <a href="https://digital.gov/guides/dap/add-your-site-dap/">https://digital.gov/guides/dap/add-your-site-dap/</a>'),
    ];
    
    $form['base_param_group']['param_agency'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Agency'),
        '#required' => true,
        '#description' => $this->t('Agency Custom dimension value'),
        '#default_value' => $this->config('fed_dap.settings')->get('param_agency'),
    ];
    
    $form['base_param_group']['param_subagency'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Sub Agency'),
        '#required' => false,
        '#description' => $this->t('Sub Agency custom dimension value'),
        '#default_value' => $this->config('fed_dap.settings')->get('param_subagency'),
    ];
    
    $form['base_param_group']['param_sitetopic'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Site Topic'),
        '#required' => false,
        '#description' => $this->t('Site Topic custom dimension value'),
        '#default_value' => $this->config('fed_dap.settings')->get('param_sitetopic'),
    ];
    
    $form['base_param_group']['param_siteplatform'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Site Platform'),
        '#required' => false,
        '#description' => $this->t('Site Platform custom dimension value'),
        '#default_value' => $this->config('fed_dap.settings')->get('param_siteplatform'),
    ];
    
     $form['js_settings_group'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('JavaScript Library Options'),
        '#weight' => 2,
        '#collapsible' => false,
        '#description' => $this->t('Specify the library configuration.'),
    ];
    $file_status = "<strong>Missing!</strong>";
     if (file_exists( DRUPAL_ROOT .'/libraries/dap/Universal-Federated-Analytics-Min.js')) {
        $file_status = "<strong>Detected</strong>";
     }
    $form['js_settings_group']['local_check'] = [
        '#markup' => $this->t('<strong>Local Library Status:</strong> <i>(/libraries/dap)</i> -- ' . $file_status)
    ];
    
    $js_library_value = $this->config('fed_dap.settings')->get('js_library');
    $jsOptions = array($this->t('Local'),$this->t('Remote'));

   $form['js_settings_group']['js_library'] = [
    '#type' => 'radios',
    '#title' => t('Selected JavaScript Library Source'),
    '#default_value' => (null !== ($js_library_value)) ? $js_library_value : $this->t('Local'),
    '#options' => $jsOptions,
    '#required' => true,
    '#description' => t('Specify which library will be used.<br /><br /><strong>Local</strong><br />Will use the local copy located at /libraries/dap<br /><br /><strong>Remote</strong><br />Will load the remote library hosted at https://dap.digitalgov.gov/Universal-Federated-Analytics-Min.js<br />'),
   ];
   /*
   $form['js_settings_group']['testing'] = [
       '#type' => 'textfield',
       '#title' => $this->t('Testing'),
       '#default_value' => print_r($js_library_value, true),
   ];
   */
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if ($form_state->getValue('example') === 'wrong') {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('The value is not correct.'),
    //     );
    //   }
    // @endcode
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('fed_dap.settings');
    $config
      ->set('param_agency', $form_state->getValue('param_agency'))
      ->set('param_subagency', $form_state->getValue('param_subagency'))
      ->set('param_sitetopic', $form_state->getValue('param_sitetopic'))
      ->set('param_siteplatform', $form_state->getValue('param_siteplatform'))
      ->set('js_library', $form_state->getValue('js_library'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
