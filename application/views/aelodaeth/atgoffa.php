<?php

/*
 * Form to choose who is to receive a reminder email
 */
?>
<h2>Message to Ex Members</h2>

<form action="" method="post">

	<p>Bydd y canlynol yn derbyn y neges hon</p>
	
	<textarea name="message" style="width:99%;height:350px;">
Annwyl {enw},

Mae'n amser i ail-ymaelodi gyda Clwb Rygbi Caernarfon. Gallwch dalu ar-lein gyda'r ddolen isod:

{unwrap}{link_cy}{/unwrap}

Bydd angen cadarnhau eich cyfeiriad ebost, o ran diogelwch data.

 # # #

Dear {enw},

It's time to re-join Caernarfon Rugby Club. You can easily pay online by following this link:

{unwrap}{link_en}{/unwrap}

Because of data security, you will need to confirm your email address.


Cofion / Regards,

Clwb Rygbi Caernarfon

--
Rydych yn derbyn y neges hon gan i chi ymuno â'r clwb arlein.
You're receiving this message as you joined the club online.

Neges awtomatig yw hon / This is an automated message</textarea>
                    
	<div class="form-actions">
		<button id="send-email" type="submit" class="btn btn-primary">Anfon y Neges</button>
		&nbsp; neu <a href="<?php echo site_url('admin/aelodaeth/cyn') ?>" rel="tooltip" title="Canslo a Dychwelyd i'r Rhestr Cyn Aelodau">Canslo</a>
	</div>
			  
	<table id="member-join-group" class="table table-hover table-striped">
		<tr>
			<th>Dewis</th>
			<th>Enw</th>
			<th>Ebost</th>
		</tr>
	<?php foreach($members as $m): ?>
		
		<tr>
			<td>
				<input type="hidden" name="member[<?=$m->id?>][name]" value="<?=$m->first_name;?> <?=$m->last_name?>" />
				<input type="hidden" name="member[<?=$m->id?>][key]" value="<?=$m->secret_key?>" />
				<input type="checkbox" name="member[<?=$m->id?>][email]" value="<?=$m->email?>" checked />
			</td>
			<td><?=$m->first_name;?> <?=$m->last_name?></td>
			<td><?=$m->email;?></td>
		</tr>
	<?php endforeach; ?>
		
	</table>                   
</form>

