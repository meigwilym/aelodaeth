<?php

?>
<h2>Membership</h2>

<div class="tac">
	<ul class="stats_box">
		<li>
			<span class="sparkline pie_aelod"><?php echo $current_count; ?>,<?php echo ($total_count - $current_count); ?></span>
			<div class="stat_text">
				<strong><?php echo $current_count; ?> / <?php echo $total_count ?></strong>Aelod Cyfredol
				<span class="percent"> <?php echo round(($current_count/$total_count)*100); ?>%</span>
			</div>
		</li>
	</ul>
</div>

<div class="tac">
	<a class="quick-btn" href="<?php echo site_url('admin/aelodaeth/all'); ?>" title="Mae <?php echo $current_count; ?> aelod cyfredol">
		<i class="icon-user icon-2x"></i>
		<span>Aelodau</span>
		<span class="label label-success"><?php echo $current_count; ?></span>
	</a>
	
	<a class="quick-btn" href="<?php echo site_url('admin/aelodaeth/cyn'); ?>" title="Mae <?php echo ($total_count - $current_count); ?> cyn aelod sydd heb ail ymaelodi">
		<i class="icon-user icon-2x" style="color:grey;"></i>
		<span>Cyn Aelodau</span>
		<span class="label label-important"><?php echo ($total_count - $current_count); ?></span>
	</a>
	
	<a class="quick-btn" href="<?php echo site_url('admin/mgroups'); ?>" title="Mae <?php echo $total_groups ?> grwp aelodaeth">
		<i class="icon-group icon-2x" style=""></i>
		<span>Grwpiau</span>
		<span class="label label-success"><?php echo $total_groups ?></span>
	</a>
	
	<a class="quick-btn" href="<?php echo site_url('admin/mgroups/edit'); ?>" title="Creu grwp aelodaeth">
		<i class="icon-group icon-2x" style=""></i>
		<span>Creu Grwp</span>
		<span class="label label-warning">+</span>
	</a>
</div>
  