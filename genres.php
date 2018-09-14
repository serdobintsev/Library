<?
if($_POST)
{
	if($action === 'add')
		$query = $dbh->prepare("INSERT INTO genres(Id, Name, Description) VALUES (NULL, (:name), (:description))");
	else
	{
		$query = $dbh->prepare("UPDATE genres SET Name = (:name), Description = (:description) WHERE Id = (:id)");
		$query->bindParam(':id', $id);
	}
	$query->bindParam(':name', $_POST['name']);
	$query->bindParam(':description', $_POST['description']);
	
	$query->execute();
}
if($action == null){ ?>

<link rel="stylesheet" type="text/css" href="items.css">

<div class="wrapp">
	<?php
	foreach($dbh->query("SELECT * FROM genres") as $genre) : ?>

	<div class="item">
		<?php echo 'Жанр <strong>' . $genre['Name'] . '</strong><br/>' . $genre['Description']; ?> <br/>
		<a href="/genres?action=edit&id=<?php echo $genre['Id']; ?>">Редактировать</a>
	</div>
	<?php endforeach; ?>
</div>
<?php
}
else
{
	?>
	<link rel="stylesheet" type="text/css" href="form.css">
	<?php
	if($action === 'edit')
	{
		$query = $dbh->prepare("SELECT * from genres where Id = ?");
		$query->execute(array($id));
		$genre = $query->fetch();
	}	
?>
<form action="/genres?action=<?php echo $action . (($id !== null) ? '&id=' . $id : ''); ?>" method="post">
<input type="text" name="name" value="<?php echo $genre['Name']; ?>"/>
<textarea name="description"><?php echo $genre['Description']; ?></textarea>
<input type="submit" />
</form>
<?php
}