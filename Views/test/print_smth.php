<?php /* @var $this \ANSR\View */ ?>
<html>
	<head></head>
	<body>
		<p><?= $this->title; ?></p>
		<table border="1">
			<tr>
				<td>ID</td>
				<td>Title</td>
				<td>Price</td>
			</tr>
			<?php foreach($this->results as $row): ?>
			<tr>
				<td><?= $row['description']; ?></td>
				<td><?= $row['title']; ?></td>
				<td><?= $row['price']; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php $this->partial('menu.php'); ?>
	</body>
</html>