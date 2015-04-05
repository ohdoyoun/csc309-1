<h2>Search for Communities</h2>
<div width: 500px;">
<?php

	echo $this->Form->create('Communities', array('action'=>'search'));
	echo $this->Form->input('tag_name');
	echo $this->Form->input('category', array(
		'type' => 'select', 
		'label' => 'Search Item Options', 
		'options' => array(
			'Profiles', 
			'Projects', 
			'All'
		),
		'selected' => 'All'
		)
	);
	echo $this->Form->input('community', array(
		'type' => 'select', 
		'label' => 'Search Category Options', 
		'options' => array(
			'Communities', 
			'Sub-Communities', 
			'All'
		),
		'selected' => 'All'
		)
	);
	echo $this->Form->end('Search');
?>
</div>
<h2>Search Results</h2>
<?php 
    if($maro_profiles == null){
        echo "<p>This is MacroTagProfiles! " + null + "</p>"; 
    }
    if($maro_profiles == null){
    echo "<p>This is MacroTagProfiles! " + null + "</p>"; 
    }
    if($maro_profiles == null){
        echo "<p>This is MacroTagProfiles! " + null + "</p>"; 
    }
    if($maro_profiles == null){
        echo "<p>This is MacroTagProfiles! " + null + "</p>"; 
    }
?>

<h3>Macro Tag</h3>
<label>Profiles</label></br>
<table style="width: 50%;">
    <tr>
        <th>Profile Name</th>
        <th>Community Name</th>
    </tr>
    <?php
    if($macro_profiles != null){
        foreach($macro_profiles as $row){
        echo "<tr>";
            echo "<td>" + $row['profiles']['id'] + "</td>";
           echo "<td>" + $row['macro_tags']['name'] + "</td>";
        echo "</tr>";
        }
    }?>
</table>
</br>

<label>Projects</label></br>
<table style="width: 50%;">
    <tr>
        <th>Project Name</th>
        <th>Community Name</th>
    </tr>
    <?php
    if($macro_projects != null){
        foreach($macro_projects as $row){
        echo "<tr>";
            echo "<td>" + $row['projects']['name']+ "</td>";
           echo "<td>" + $row['macro_tags']['name']+ "</td>";
        echo "</tr>";
        }
    }?>
</table></br>
</br>

<h3>Micro Tag</h3>
<label>Profiles</label></br>
<table style="width: 50%;">
    <tr>
        <th>Profile Name</th>
        <th>Sub-Community Name</th>
    </tr>
    <?php
    if($micro_profiles != null){
        foreach($micro_profiles as $row){
        echo "<tr>";
            echo "<td>" + $row['profiles']['id'] + "</td>";
           echo "<td>" + $row['micro_tags']['name']+ "</td>";
        echo "</tr>";
        }
    }?>
</table>
</br>

<label>Projects</label></br>
<table style="width: 50%;">
    <tr>
        <th>Project Name</th>
        <th>Sub-Community Name</th>
    </tr>
    <?php 
    if($micro_projects != null){
        foreach($micro_projects as $row){
        echo "<tr>";
            echo "<td>" + $row['projects']['name']+ "</td>";
           echo "<td>" + $row['micro_tags']['name']+ "</td>";
        echo "</tr>";
        }
    }
    ?>
</table>
