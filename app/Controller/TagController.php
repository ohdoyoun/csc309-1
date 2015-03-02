<?php 
/* Abstract Tag Controller class. Used to generalize the Tag Search functions. */
class TagController extends AppController{

  /* Searches a given Model table for all entries associated with $tag_name.
  - $tag_name = the name of the tag the user is interested in.
  - $tag_model_name = the name of the Tag Model to be used in the search.
            Must be either MacroTag or MicroTag.
    $model_name = The name of the Model that holds the associations to search.
            Must be one of the following:
                    - ProfilesMacroTag
                    - ProfilesMicroTag
                    - ProjectsMacroTag
                    - ProjectsMicroTag
  - $like = Wether to use the SQL LIKE operator when searching.
  */
  public function getAll($tag_name, $tag_model_name, $model_name, $like=true){
    var $tag_id = $this->$tag_model_name->search($tag_name, $like);
  }
}
?>
