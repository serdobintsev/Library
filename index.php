<?php
function print_select($collection, $name, $selected_id = null)
{
	echo "<select name=\"$name\">";
	foreach($collection as $item)
		echo '<option ' . (($selected_id != null && $selected_id == $item['Id']) ? 'selected ' : '') . 'value="' . $item['Id'] . '">' . $item['Name'] . '</option>' . "\n";
	echo "</select>";
}
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>Библиотека</title>
</head>
<body>
<table width="100%">
	<tr>
		<td colspan="4">
		<a href="/">Главная</a>
		</td>
	</tr>
	<tr>
		<td>
		<a href="/books?action=add">Добавить книгу</a>
		</td>
		<td>
		<a href="/authors?action=add">Добавить автора</a>
		</td>
		<td>
		<a href="/genres?action=add">Добавить жанр</a>
		</td>
		<td>
		<a href="/publishing_house?action=add">Добавить издание</a>
		</td>
	</tr>
	<tr>
		<td>
		<a href="/books">Список книг</a>
		</td>
		<td>
		<a href="/authors">Список авторов</a>
		</td>
		<td>
		<a href="/genres">Список жанров</a>
		</td>
		<td>
		<a href="/publishing_house">Список изданий</a>
		</td>
	</tr>
</table>
<?php
	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri_segments = explode('/', $uri_path);
	$table = null;
	if($_GET['action'] && ($_GET['action'] === 'add' || $_GET['action'] === 'edit'))
	{
		$action = $_GET['action'];
		if($action === 'edit')
			if($_GET['id'])
				$id = $_GET['id'];
			else
				throw new exception('Не передан id');
	}
	
	if(file_exists($uri_segments[1] . '.php'))
	{
		require_once "connection.php";
		$dbh = new PDO($dsn, $user, $password, $options);
		require_once $uri_segments[1] . '.php';
	}
?>
</body>
</html>