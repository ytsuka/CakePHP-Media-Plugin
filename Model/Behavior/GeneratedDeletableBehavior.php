<?php
/**
 * Generated Deletable Behavior File
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP 5
 * CakePHP 2
 *
 * @author        Ben McClure
 * @package       Media.Model.Behavior
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Generated Deletable Behavior Class
 *
 * @package       Media.Model.Behavior
 */
class GeneratedDeletableBehavior extends ModelBehavior {
    
	public function beforeDelete(Model $Model, $cascade = true) {
		if (!$cascade) {
			return true;
		}

		$result = $Model->find('first', array(
			'conditions' => array($Model->primaryKey => $Model->id),
			'fields' => array('dirname', 'basename'),
			'recursive' => -1,
		));
                
		if (empty($result)) {
			return false;
		}
                if (empty($result[$Model->alias]['basename']) && empty($result[$Model->alias]['dirname'])) {
                    return true;
                }

		$pattern = MEDIA_FILTER.'*'.DS.$result[$Model->alias]['dirname'].DS;
		$pattern .= pathinfo($result[$Model->alias]['basename'], PATHINFO_FILENAME).'.*';

		$files = glob($pattern);

		/*
		$versions = array_keys($Model->Generator->filter($Model, $result[$Model->alias]['basename']));
		if (count($files) > count($versions)) {
			$message  = 'GeneratedDeletable::beforeDelete - ';
			$message .= "Pattern `{$pattern}` matched more than number of versions. ";
			$message .= "Failing deletion of versions and record for `Media@{$Model->id}`.";
			CakeLog::write('warning', $message);
			return false;
		}
		*/

		foreach ($files as $file) {
			$file = new File($file);

			if (!$file->delete()) {
				return false;
			}
		}

		return true;
	}
}
?>