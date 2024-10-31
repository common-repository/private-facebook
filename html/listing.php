<?php $limit = 30; ?>
<?php $page = (isset($_GET['current_page']))?($_GET['current_page']):(0); ?>
<?php $last = floor(count($users) / $limit); ?>
	<div id="listing">
		<table width="100%" class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th class="manage-column column-title sortable desc" width="90%">Name (<?= count($users) ?>)</th>
					<th class="manage-column column-title sortable desc" style="text-align:center">Status</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php $i = 0; ?>
				<?php foreach ($users as $user) : ?>
				<tr class="news type-news status-publish hentry iedit author-other <?= ($i++ % 2 == 0)?('alternate'):('') ?>" user-id="<?= $user->facebook_id ?>">
					<td class="post-title page-title column-title"><a href="http://www.facebook.com/profile.php?id=<?= $user->facebook_id ?>" target="_blank"><?= $user->name ?></a> <small><?= $user->mail ?></small></td>
					<td class="post-title page-title column-title" style="text-align:center; padding-top: 19px;">
						<a onclick="changeStatus('<?= $user->facebook_id ?>', 'deny')" class="button-secondary action big allow <?= ($user->status == 'allow')?(''):('hidden') ?>">Allowed</a>
						<a onclick="changeStatus('<?= $user->facebook_id ?>', 'allow')" class="button-secondary action big deny <?= ($user->status == 'deny')?(''):('hidden') ?>">Denied</a>
					</td>
				</tr>
				<?php $i++ ?>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="manage-column column-title sortable desc" colspan="2" style="text-align:left; padding-left:15px">Page
					<?php
						for ($i = 0; $i <= $last; $i++) {
							if ($page != $i)
								echo '<a href="admin.php?page=private-facebook-settings&current_page='. $i .'">';
							echo $i + 1 . ' ';
							if ($page != $i)
								echo '</a>';
						}
					?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div> <!-- #private-facebook -->
<script>
function changeStatus(facebook_id, status) {
	var data = {
		action: 'change_status',
		facebook_id: facebook_id,
		status: status
	};

	jQuery.post(ajaxurl, data, function(data) {
		jQuery('[user-id=' + facebook_id + '] .allow, [user-id=' + facebook_id + '] .deny').toggle();
	});
}
</script>