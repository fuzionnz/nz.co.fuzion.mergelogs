<?php

class CRM_Mergelogs_CopyLog {

  public static function copyLogs($otherCid, $mainCid) {
    $logTables = self::getLogTables();
    foreach ($logTables as $table => $log) {
      $sql = "SELECT * FROM {$table} WHERE {$log['fk']} = {$otherCid}";
      if (!empty($log['entity_table'])) {
        $sql .= " AND entity_table = 'civicrm_contact'";
      }
      $tmpTblObj = CRM_Utils_SQL_TempTable::build()->createWithQuery($sql);
      $tmpTbl = $tmpTblObj->getName();

      CRM_Core_DAO::executeQuery("UPDATE {$tmpTbl} SET {$log['fk']} = {$mainCid} WHERE {$log['fk']} = {$otherCid}");

      CRM_Core_DAO::executeQuery("INSERT IGNORE INTO {$table} SELECT * FROM {$tmpTbl}");
      $tmpTblObj->drop();
    }
  }

  public static function getLogTables() {
    $logTables = [
      'log_civicrm_contact' => [
        'fk' => 'id',
      ],
      'log_civicrm_email' => [
        'fk' => 'contact_id',
      ],
      'log_civicrm_phone' => [
        'fk' => 'contact_id',
      ],
      'log_civicrm_address' => [
        'fk' => 'contact_id',
      ],
      'log_civicrm_note' => [
        'fk' => 'entity_id',
        'entity_table' => TRUE,
      ],
      'log_civicrm_group_contact' => [
        'fk' => 'contact_id',
      ],
      'log_civicrm_entity_tag' => [
        'fk' => 'entity_id',
        'entity_table' => TRUE,
      ],
      'log_civicrm_relationship' => [
        'fk' => 'contact_id_a',
      ],
      'log_civicrm_activity_contact' => [
        'fk' => 'contact_id',
      ],
      'log_civicrm_case_contact' => [
        'fk' => 'contact_id',
      ],
    ];

    $logging = new CRM_Logging_Schema();

    // build _logTables for contact custom tables
    $customTables = $logging->entityCustomDataLogTables('Contact');
    foreach ($customTables as $table) {
      $logTables[$table] = [
        'fk' => 'entity_id',
      ];
    }

    return $logTables;
  }


}