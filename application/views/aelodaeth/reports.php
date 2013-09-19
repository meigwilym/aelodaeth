<?php
/*
* display membership and bill reports
*/
?>

<p>Only received payments are shown. </p>

<form action="" method="post" class="form">
	
	<div class="control-group span5 offset7">
		<label for="dyddiad" class="control-label">Dyddiad</label>
		<div class="controls span7">
			<div class="input-append date" id="reportdate" data-date="<?=$reportdate ?>" data-date-viewmode="months" data-date-format="mm/yyyy" data-date-minviewmode="months">
				<input id="report-date" size="16" type="text" name="reportdate" value="<?=$reportdate ?>" readonly />
				<span class="add-on"><i class="icon-calendar"></i></span>
			</div>
			<span class="help-block">Choose a month to see the report</span>
		</div>
		
		<button type="submit" class="btn btn-primary">Show Report</button>
	</div>
	
</form>
<hr />
<?php if($report):?>

<p>Cyfanswm aelodau: <strong><?php echo count($report); ?></strong></p>

<table class="table table-striped table-hover">
	<tr>
		<th>Rhif</th>
		<th>Enw</th>
		<th>Lefel Aelodaeth</th>
		<th>Dyddiad talu</th>
		<th>Dull</th>
		<th>Cash</th>
		<th>Cheque</th>
		<th>Arlein</th>
		<th>Nodiadau</th>
	</tr>
<?php 
	$cash_total = 0;
	$cheque_total = 0;
	$gc_total = 0;
	foreach($report as $r): 
		
		if($r->method == 'cash') $cash_total += $r->amount;
		if($r->method == 'cheque') $cheque_total += $r->amount;
		if($r->method == 'gocardless') $gc_total += $r->amount;
?>
	<tr>
		<td><?=$r->id?></td>
		<td><?=anchor('admin/aelodaeth/edit/'.$r->id,$r->first_name.' '.$r->last_name)?></td>
		<td><?=$r->membership_type?></td>
		<td><?=printdate('d/m', $r->created_on)?></td>
		<td><?=$r->method?></td>
		<td class="financial"><?php if($r->method == 'cash') echo '£'.$r->amount.'.00' ?></td>
		<td class="financial"><?php if($r->method == 'cheque') echo '£'.$r->amount.'.00' ?></td>
		<td class="financial"><?php if($r->method == 'gocardless') echo '£'.$r->amount.'.00' ?></td>
		<td><?=$r->notes?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	<tfoot>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td><strong>Cyfanswm: </strong></td>
			<td class="financial"><strong>£<?=$cash_total?>.00</strong></td>
			<td class="financial"><strong>£<?=$cheque_total?>.00</strong></td>
			<td class="financial"><strong>£<?=$gc_total?>.00</strong></td>
			<td><strong>&nbsp</strong></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td><strong>Cyfanswm Misol:</strong></td>
			<td class="financial"><strong>£<?php echo ($cash_total+$cheque_total+$gc_total); ?>.00</strong></td>
			<td colspan="3"></td>
	</tfoot>
</table>
<?php else: ?>
<p>Nid oedd taliadau am y cyfnod hwn.</p>
<?php endif; ?>
