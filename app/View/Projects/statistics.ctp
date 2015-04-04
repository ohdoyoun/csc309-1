<!-- <h2>Global Statistics</h2>
<table style="width: 40%">
    <tr>
        <th>Users:</th>
        <td><?php echo $numberOfUsers[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Profiles:</th>
        <td><?php echo $numberOfProfiles[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Project:</th>
        <td><?php echo $numberOfProjects[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Communities:</th>
        <td><?php echo $numberOfCommunities[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Money in the system:</th>
        <td><?php echo $moneyInSystem[0][0]['total']; ?></td>
    </tr>
    
    <tr>
        <th>Money spent on projects:</th>
        <td><?php echo $moneySpent[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects being funded:</th>
        <td><?php echo $projectsBeingFunded[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects not being funded:</th>
        <td><?php echo $projectsNotBeingFunded[0][0]['total'] - $projectsBeingFunded[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Active projects:</th>
        <td><?php echo $projectsActive[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects that ended:</th>
        <td><?php echo $projectsDone[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects that completed their goal:</th>
        <td><?php echo $projectsFullyFunded[0][0]['total']; ?></td>
    </tr>
</table>

<br><br><br>
<h2>Statistics of your projects</h2>
<table style="width: 34%">
    <tr>
        <th>Projects you have initiated:</th>
        <td><?php echo $numberOfProjectsUser[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Money raised on all projects:</th>
        <td><?php echo $moneyRaised[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects being funded:</th>
        <td><?php echo $projectsBeingFundedUser[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects not being funded:</th>
        <td><?php echo $projectsNotBeingFundedUser[0][0]['total'] - $projectsBeingFundedUser[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Active projects:</th>
        <td><?php echo $projectsActiveUser[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects that ended:</th>
        <td><?php echo $projectsDoneUser[0][0]['total']; ?></td>
    </tr>
    <tr>
        <th>Projects that completed their goal:</th>
        <td><?php echo $projectsFullyFundedUser[0][0]['total']; ?></td>
    </tr>
</table> -->

<h2>Global Statistics</h2>
<h5>Number of users: <?php echo $numberOfUsers[0][0]['total']; ?></h5>
<h5>Number of profiles: <?php echo $numberOfProfiles[0][0]['total']; ?></h5>
<h5>Number of projects: <?php echo $numberOfProjects[0][0]['total']; ?></h5>
<h5>Number of communities: <?php echo $numberOfCommunities[0][0]['total']; ?></h5><br>

<h5>Money in the system: <?php echo $moneyInSystem[0][0]['total']; ?></h5>
<h5>Money spent on projects: <?php echo $moneySpent[0][0]['total']; ?></h5><br>

<h5>Projects being funded: <?php echo $projectsBeingFunded[0][0]['total']; ?></h5>
<h5>Projects not being funded: <?php echo $projectsNotBeingFunded[0][0]['total'] - $projectsBeingFunded[0][0]['total']; ?></h5><br>

<h5>Number of active projects: <?php echo $projectsActive[0][0]['total']; ?></h5>
<h5>Number of projects that ended: <?php echo $projectsDone[0][0]['total']; ?></h5><br>

<h5>Number of projects that completed their goal: <?php echo $projectsFullyFunded[0][0]['total']; ?></h5>


<br><br><br><h2>Statistics of your projects</h2>
<h5>Number of projects you have initiated: <?php echo $numberOfProjectsUser[0][0]['total']; ?></h5><br>
<h5>Money raised on all projects: <?php echo $moneyRaised[0][0]['total']; ?></h5><br>
<h5>Projects being funded: <?php echo $projectsBeingFundedUser[0][0]['total']; ?></h5>
<h5>Projects not being funded: <?php echo $projectsNotBeingFundedUser[0][0]['total'] - $projectsBeingFundedUser[0][0]['total']; ?></h5><br>
<h5>Number of active projects: <?php echo $projectsActiveUser[0][0]['total']; ?></h5>
<h5>Number of projects that ended: <?php echo $projectsDoneUser[0][0]['total']; ?></h5><br>

<h5>Number of projects that completed their goal: <?php echo $projectsFullyFundedUser[0][0]['total']; ?></h5>