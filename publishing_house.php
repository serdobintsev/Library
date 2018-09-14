<?
if($_POST)
{
	if($action === 'add')
		$query = $dbh->prepare("INSERT INTO publishing_house(Id, Name, Country, Address, year_of_foundation) VALUES (NULL, (:name), (:country), (:address), (:year))");
	else
	{
		$query = $dbh->prepare("UPDATE publishing_house SET Name=(:name), Country=(:country), Address=(:address), year_of_foundation=(:year) WHERE Id = (:id)");
		$query->bindParam(':id', $id);
	}
	$query->bindParam(':name', $_POST['name']);
	$query->bindParam(':year', $_POST['year']);
	$query->bindParam(':address', $_POST['address']);
	$query->bindParam(':country', $_POST['country']);
	
	$query->execute();
}
if($action == null){ ?>

<link rel="stylesheet" type="text/css" href="items.css">

<div class="wrapp">
	<?php
	foreach($dbh->query("SELECT publishing_house.Id, publishing_house.Name, countries.Name as CountryName, Country, Address, year_of_foundation FROM publishing_house INNER JOIN countries ON Country = countries.Id") as $publishing_house) : ?>
	<div class="item">
		<?php echo 'Издание <strong>' . $publishing_house['Name'] . '</strong> (<strong>' . $publishing_house['year_of_foundation'] . '</strong> г.), страна <strong>' . $publishing_house['CountryName'] . '</strong>.' .
					'<br/>' . $publishing_house['Address']; ?> <br/>
		<a href="/publishing_house?action=edit&id=<?php echo $publishing_house['Id']; ?>">Редактировать</a>
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
		$query = $dbh->prepare("SELECT * from publishing_house where Id = ?");
		$query->execute(array($id));
		$publishing_house = $query->fetch();
	}
	$countries = $dbh->query("SELECT Id, Name FROM countries");
?>
<form action="/publishing_house?action=<?php echo $action . (($id !== null) ? '&id=' . $id : ''); ?>" method="post">
<input type="text" name="name" value="<?php echo $publishing_house['Name']; ?>"/>
<input type="number" name="year" value="<?php echo $publishing_house['year_of_foundation']; ?>"/>
<textarea name="address"><?php echo $publishing_house['Address']; ?></textarea>
<?php
	print_select($countries, 'country', $publishing_house['Country']);
	echo "<br/>";
?>
<input type="submit" />
</form>
<?php
}