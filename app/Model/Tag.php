<?php
/* Abstract class for Tags! 
- Not associated with any table in the database!
*/
App::uses('AppModel', 'Model');
class Tag extends AppModel{
	
	// The name of this Model.
	public $name = 'Tag';
	
	// The table that this Model uses.
	public $useTable = null;
	
	// The validation rules that this Model uses.
	public $validate = array(
		'name' => array(
			'alphaNumeric' => array
			(
				'rule' => 'alphaNumeric',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Tag names may only contain alphanumeric characters.'
			),
			'between' => array
			(
				'rule' => array('lengthBetween', 1, 50),
				'message' => 'Tag names must be between 1 to 50 characters.'
			)
			
		)
	);
	
	/* Searches though tags for tags given a certain tag name.
	- If $like = true, then searches using the SQL LIKE operator.
	- Otherwise, searches for exact $tag_name.*/
	public function searchName($tag_name, $like=true){
		if($like){
			$condition = '%' + $tag_name + '%';
			$ans = $this->find('all', array(
				'conditions' => array('name LIKE' => $condition),
				'fields' => array('id'),
				'callbacks' => false
				)
			);
			return $ans;
		}else{
			$ans = $this->find('all', array(
				'conditions' => array('name' => $tag_name),
				'fields' => array('id'),
				'callbacks' => false
				)
			);
			return $ans;
		}
	}

}
?>
