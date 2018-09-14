<?
if($_POST)
{
	if($action === 'add')
		$query = $dbh->prepare("INSERT INTO authors(Id, FirstName, LastName, Birthday) VALUES (NULL, (:first_name), (:last_name), (:birthday))");
	else
	{
		$query = $dbh->prepare("UPDATE authors SET FirstName=(:first_name), LastName=(:last_name), Birthday=(:birthday) WHERE Id = (:id)");
		$query->bindParam(':id', $id);
	}
	$query->bindParam(':first_name', $_POST['first_name']);
	$query->bindParam(':last_name', $_POST['last_name']);
	$query->bindParam(':birthday', $_POST['birthday']);
	
	$query->execute();
}
if($action == null){ ?>

<link rel="stylesheet" type="text/css" href="items.css">

<div class="wrapp">
	<?php
	foreach($dbh->query("SELECT * FROM authors") as $author) : ?>

	<div class="item">
		<?php echo 'Автор <strong>' . $author['FirstName'] . ' '. $author['LastName'] . '</strong>, день рождения <strong>' . $author['Birthday'] . '</strong>'; ?> <br/>
		<a href="/authors?action=edit&id=<?php echo $author['Id']; ?>">Редактировать</a>
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
		$query = $dbh->prepare("SELECT * from authors where Id = ?");
		$query->execute(array($id));
		$author = $query->fetch();
	}
?>
<form action="/authors?action=<?php echo $action . (($id !== null) ? '&id=' . $id : ''); ?>" method="post">
<input type="text" name="first_name" value="<?php echo $author['FirstName']; ?>"/>
<input type="text" name="last_name" value="<?php echo $author['LastName']; ?>"/>
<input type="date" name="birthday" value="<?php echo $author['Birthday']; ?>"/>
<input type="submit" />
</form>
<?php
}