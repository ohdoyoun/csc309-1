<h2>All Communities</h2>

<table style="width: 50%;">
    <tr>
        <th>Community name</th>
        <th>Main category</th>
    </tr>
    <?php foreach($communities as $community): ?>
    <tr>
        <td><a href="/communities/view/<?php echo $community['communities']['id']; ?>"><?php echo $community['micro_tags']['name']; ?></a></td>
        <td><?php echo $community['macro_tags']['name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>