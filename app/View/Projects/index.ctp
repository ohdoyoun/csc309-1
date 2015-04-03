<h2>Discover Projects</h2>

<?php foreach($projects as $project): ?>
    
    <div style="float: left; padding-right: 30px; border-style: ridge; border-width: 5px; padding-left: 30px; width: 250px; height: 300px; padding-top: 15px; margin-right: 10px;">
        <p>Name: <a href="projects/view/<?php echo $project['Project']['id']; ?>"><?php echo $project['Project']['project_name']; ?></a></p><br>
        <p>Details: <?php echo $project['Project']['details']; ?></p><br><br>
        <p>Goal: $<?php echo $project['Project']['goal']; ?></p>
        <p>Funded: $?</p><br>

        <p>Ending on <?php echo $project['Project']['end_date']; ?></p>
    </div>
<?php endforeach; ?>
