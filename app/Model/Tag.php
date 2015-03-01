<?php
public class Tag extends AppModel{
	
	public var $validate = array(
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
	
	/* Searches though tags for tags given a certain tag name. */
	public function search($tag_name){
		var $ans = find('all', 
			array(
				'conditions' => array('name' => $tag_name),
				'fields' => array('id', 'name'),
				'callbacks' => false
			)
		);
		return $ans
	}

	/* Searches though tags for tags given a certain tag name.
	- Uses LIKE comparison
	 */
	public function searchLike($tag_name){
		var $condition = '%' + $tag_name + '%';
		var $ans = find('all', 
			array(
				'conditions' => array('name LIKE' => $condition),
				'fields' => array('id', 'name'),
				'callbacks' => false
			)
		);
		return $ans
	}
}
?>