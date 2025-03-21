<div class="edgt-social-share-holder edgt-dropdown">
	<a href="javascript:void(0)" target="_self" class="edgt-social-share-dropdown-opener">
		<i class="icon-share-alt"></i>
	</a>

	<div class="edgt-social-share-dropdown">
		<ul>
			<?php foreach($networks as $net) {
				echo eldritch_edge_get_module_part($net);

			} ?>
		</ul>
	</div>
</div>