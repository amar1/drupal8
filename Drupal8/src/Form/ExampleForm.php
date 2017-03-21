<?php
/** 
 * @file
 * Contains \Drupal\example\Form\ExampleForm.
 */ 
namespace Drupal\example\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Implements an example form.
 */
class ExampleForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'example_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
    );
    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email'),
      '#required' => TRUE,
    );
    $form['phone_number'] = array(
      '#type' => 'tel',
      '#title' => t('Your phone number'),
      '#required' => TRUE,
    );
    $form['colour'] = array(
      '#type' => 'textfield',
      '#title' => t('colour'),
      '#required' => TRUE,
    );
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 3) {
      $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
    }
    $allowed = array('blue', 'yellow', 'pink', 'purple');
    if (!in_array($form_state->getValue('colour'), $allowed)) {
      $form_state->setErrorByName('colour', $this->t('You must enter a valid colour.'));
    }
  } 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $phone_number = $_POST['phone_number'];
  	$name = $_POST['name'];
  	$email = $_POST['email'];
    $colour = $_POST['colour'];
    $query = \Drupal::database()->insert('example');
    $query->fields(['your_name','email','phone','colour']);
  	$query->values([$name,$email,$phone_number,$colour]);
  	$query->execute();
    drupal_set_message($this->t('Successfully Submitted'));
  } 
}  