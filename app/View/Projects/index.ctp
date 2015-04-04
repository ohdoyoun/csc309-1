<h2>Discover Projects</h2>

<?php $setRaised = false; ?>
<?php foreach($projects as $project): ?>
    
    <div style="float: left; padding-right: 30px; border-style: ridge; border-width: 5px; padding-left: 30px; width: 250px; height: 300px; padding-top: 15px; margin-right: 10px;">
        <p>Name: <a href="/projects/view/<?php echo $project['Project']['id']; ?>"><?php echo $project['Project']['project_name']; ?></a></p><br>
        <p>Goal: $<?php echo $project['Project']['goal']; ?></p>
        <?php foreach($current_amounts as $current):
            if ($current['transactions']['project_id'] == $project['Project']['id']) {?>
                <p>Raised: $<?php echo $current[0]['total']?></p><br>
                <?php $setRaised = true;
            }
        endforeach;
        if (!$setRaised) { ?>
            <p>Raised: $0</p><br>
        
        <?php } else {
            $setRaised = false;
        } ?>
        
        
        <p>Ending on <?php echo $project['Project']['end_date']; ?></p><br>
        <p style="text-overflow: ellipsis; word-wrap:break-word;">Details: <?php echo $project['Project']['details']; ?></p><br><br>

    </div>
<?php endforeach; ?>
