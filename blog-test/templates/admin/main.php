<h1 class="title"> Admin Page </h1>

<a href="/admin/create" class="button">New article + </a>

<table>
	<thead>
	<tr>
		<td>id</td>
		<td>title</td>
		<td>status</td>
		<td>time created</td>
		<td>edit</td>
		<td>delete</td>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($data['articles'] as $key => $article) { ?>
			<tr class="<?= $key % 2 === 0 ? 'odd' : 'even'?>">
				<td><?=$article['id']?></td>
				<td><?=$article['title']?></td>
				<td><?=$article['status']?></td>
				<td><?= date('Y-m-d H:i', $article['time_created'])?></td>
				<td><a href="admin/edit/<?=$article['id']?>">edit</a></td>
				<td><a href="admin/delete/<?=$article['id']?>">delete</a></td>
			</tr>
			
	
		<?php } ?>
	</tbody>
</table>