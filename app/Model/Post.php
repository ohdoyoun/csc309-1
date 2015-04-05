<?php 
class Post extends AppModel{

  // Table to use in the database.
  public $useTable = 'posts';
  
  // Name of this Model.
  public $name = 'Post';
  
  // Associations to other Models.
  public $belongsTo = array(
    'Community' => array(
      'className' => 'Community',
      'foreignKey' => 'communities_id'
    ),
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    )
      
  );

}
?>
