<?php

require_once 'mergelogs.civix.php';
use CRM_Mergelogs_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function mergelogs_civicrm_config(&$config) {
  _mergelogs_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function mergelogs_civicrm_xmlMenu(&$files) {
  _mergelogs_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mergelogs_civicrm_install() {
  _mergelogs_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function mergelogs_civicrm_postInstall() {
  _mergelogs_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function mergelogs_civicrm_uninstall() {
  _mergelogs_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function mergelogs_civicrm_enable() {
  _mergelogs_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function mergelogs_civicrm_disable() {
  _mergelogs_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function mergelogs_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mergelogs_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function mergelogs_civicrm_managed(&$entities) {
  _mergelogs_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function mergelogs_civicrm_caseTypes(&$caseTypes) {
  _mergelogs_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function mergelogs_civicrm_angularModules(&$angularModules) {
  _mergelogs_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function mergelogs_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mergelogs_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function mergelogs_civicrm_entityTypes(&$entityTypes) {
  _mergelogs_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function mergelogs_civicrm_themes(&$themes) {
  _mergelogs_civix_civicrm_themes($themes);
}

function mergelogs_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Contact_Form_Merge') {
    $form->setDefaults(['copy_change_logs' => 1]);
    $form->addElement('checkbox', 'copy_change_logs', 'Copy Change Logs');
    $template = CRM_Core_Smarty::singleton();
    $rows = $template->get_template_vars('rows');
    $rows['copy_change_logs'] = [
      'title' => 'Copy Change Logs',
    ];
    $template->assign('rows', $rows);
  }
}

function mergelogs_civicrm_merge($type, &$data, $mainId = NULL, $otherId = NULL, $tables = NULL) {
  if ($type == 'sqls' && !empty($_POST['copy_change_logs'])) {
    CRM_Mergelogs_CopyLog::copyLogs($otherId, $mainId);
  }
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function mergelogs_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function mergelogs_civicrm_navigationMenu(&$menu) {
  _mergelogs_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _mergelogs_civix_navigationMenu($menu);
} // */
