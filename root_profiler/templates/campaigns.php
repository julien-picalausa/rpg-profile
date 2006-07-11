<?php global $sid, $campaigns; ?>


<h1><?php echo getUserName(); ?> :: Campaigns</h1>

<h1>New Campaign</h1>
<form action="new_campaign.php" method="post">
  <p>
    To create a new campaign, enter a name below. 
    Campaign names must be alphanumeric and 40 characters or less.
  </p>
  <table>
    <tr>
      <td>Campaign name:</td>
      <td><input type="text" name="newname" class="quick" maxlength="20" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit"class="go" value="Create" /></td>
    </tr>
  </table>
</form>
<h1>View/Edit Campaigns</h1>
  <p class="indent">
    If you wish to edit or view any of your existing campaigns, select
    from the list below.
  </p>
  <table class="clist indent">
<?php 
if( count( $campaigns ) > 0 ) {
?>
    <thead>
      <tr>
        <th>ID</th>
        <th>Campaign</th>
        <th>Players</th>
        <th>Open</th>
        <th>Active</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
<?php
  foreach( $campaigns as $campaign ) {
?>
      <tr>
        <td class="c"><?php echo $campaign['id']; ?></td>
        <td><a href="view_campaign.php?id=<?php echo $campaign['id']; ?>"><?php echo $campaign['name']; ?></a></td>
        <td class="c"><?php echo $campaign['pcs']; ?></td>
        <td class="c"><?php if( $campaign['open'] ) { ?>Yes<?php } else { ?>No<?php } ?></td>
        <td class="c"><?php if( $campaign['active'] ) { ?>Yes<?php } else { ?>No<?php } ?></td>
        <td><a href="edit_campaign.php?id=<?php echo $campaign['id']; ?>">Edit</a></td>
        <?php if( $campaign['website'] ) { ?>
        <td class="c"><a href="<?php echo $campaign['website']; ?>">Website</a></td>
        <?php } ?>
      </tr>
<?php
  }
} else { ?>
      <tr>
        <td colspan="5">You don't have any campaigns!</td>
      </tr>
<?php } ?>
    </tbody>
  </table>

