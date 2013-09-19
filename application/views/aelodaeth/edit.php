<?php
/**
 * single member page
 * also show complete subs history
 * 
 */

// enable form fields when creating a new member
$m = isset($member);
?>
<div class="row-fluid">
    <div class="span6">
        <div class="box">
            <header>
                <h5><?php echo (isset($member->id)) ? 'Golygu' : 'Ychwanegu'; ?> Aelod</h5>
                
            <?php if(isset($member->id)): ?>
                <div class="toolbar">
                    <a href="#" class="btn btn-success" id="allow-edit" title="Clic i newid manylion <?=$member->first_name?>"><i class="icon-edit"></i> </a>
                </div>
            <?php endif; ?>
                
            </header>
            <div class="body">
                <?php echo validation_errors();?>
                <form action="" method="post" class="form form-horizontal" id="edit-member">
                    
                    
                <?php if(isset($member->id)): ?>
                    <input type="hidden" name="id" value="<?php echo $member->id; ?>" />
                    <div  class="control-group">
                        <label class="control-label">Rhif:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $member->id; ?>" class="small" disabled />
                        </div>
                    </div>
                <?php endif; ?>
                    
                    <div  class="control-group">
                        <label for="first_name" class="control-label">Enw Cyntaf:</label>
                        <div class="controls">
                            <input type="text" name="first_name" id="first_name" value="<?php echo @set_value('first_name', $member->first_name); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Cyfenw:</label>
                        <div class="controls">
                            <input type="text" name="last_name" id="last_name" value="<?php echo @set_value('last_name', $member->last_name); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Ebost:</label>
                        <div class="controls">
                            <input type="email" name="email" id="email" value="<?php echo @set_value('email', $member->email); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Cyfeiriad 1:</label>
                        <div class="controls">
                            <input type="text" name="billing_address1" id="billing_address1" value="<?php echo @set_value('billing_address1', $member->billing_address1); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Cyfeiriad 2:</label>
                        <div class="controls">
                            <input type="text" name="billing_address2" id="billing_address2" value="<?php echo @set_value('billing_address2', $member->billing_address2); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Tref:</label>
                        <div class="controls">
                            <input type="text" name="billing_town" id="billing_town" value="<?php echo @set_value('billing_town', $member->billing_town); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Cod Post:</label>
                        <div class="controls">
                            <input type="text" name="billing_postcode" id="billing_postcode" value="<?php echo @set_value('billing_postcode', $member->billing_postcode); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    <div  class="control-group">
                        <label for="" class="control-label">Ff&ocirc;n:</label>
                        <div class="controls">
                            <input type="text" name="rhif_ffon" id="rhif_ffon" value="<?php echo @set_value('rhif_ffon', $member->rhif_ffon); ?>" class="" <?=set_disabled($m)?> />
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" <?=set_disabled($m)?> id="save-edit">Cadw</button>
                    
                        <?php $refer_url = $this->session->flashdata('refer'); ?>
                        &nbsp; neu <a href="<?=$refer_url?>" rel="tooltip" title="Canslo a Dychwelyd i'r Rhestr Aelodaeth">Canslo</a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <div class="span6"><?   ###################################  Payment History ?>
    <?php if(isset($member->id) && count($member->subs) > 0): ?>
         <div class="box">
            <header>
                <h5>Taliadau</h5>
            </header>
            <div class="body">
                <table id="member_payments" class="table table-responsive table-striped table-condensed">
                    <tr>
                        <th>Dyddiad</th>
                        <th>Swm</th>
                        <th>Lefel</th>
                        <th>Hyd at</th>
                        <th>Dull</th>
                        <th>&nbsp;</th>
                        <th class="subs-note">&nbsp;</th>
                    </tr>
                   
                    <?php
                    foreach($member->subs as $s):
                        // show red for expired, green for current or yellow for pending
                        $class = (mktime() < strtotime($s->ends_on)) ? ( ($s->status == 'paid') ? 'success' : 'warning') : 'error';
                    ?>
                        <tr class="<?php echo $class; ?>">
                            <td title="Subs ID: <?=$s->subs_id?>"><?php echo date('j M, Y', strtotime($s->created_on)); ?></td>
                            <td>£<?php echo $s->amount; ?></td>
                            <td><?php echo $s->membership_type; ?></td>
                            <td><?php echo date('Y', strtotime($s->ends_on)); ?></td>
                            <td><?php echo ucfirst($s->method); ?></td>
                            <td><?php
                            if(!is_null($s->notes) && $s->notes != '')
                            {
                                echo '<button class="btn view-note" title="Darllen y nodyn sydd ar y taliad hwn"><i class="icon-edit"></i></button>';
                                echo '</td>';
                                echo '<td class="subs-note">'.$s->notes;
                            }
                            else
                                echo '&nbsp;';
                          ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </table>
                <p><?php echo anchor('admin/aelodaeth/adnewyddu/'.$member->id, 'Adnewyddu', array('class'=>'btn btn-primary')); ?>
                    <span class="help-inline">Adnewyddu Aelodaeth <?php echo $member->first_name.' '.$member->last_name; ?></span>.</p>
            </div>
        </div>
        <div class="box">
            <header>
                <h5>Gwybodaeth</h5>
            </header>
            <div class="body">
                <p>Crewyd ar <?=date('d/m/Y H:i', strtotime($member->m_created_on));?></p>
                
                <?php if($member_groups): ?>
                <p>Mae <?=$member->first_name?> yn aelod o'r grwpiau canlynol:</p>
                <ul>
                    <?php foreach($member_groups as $g): ?>
                <li><?php echo anchor('admin/mgroups/grwp/'.$g->id, $g->groupname_cy.'|'.$g->groupname_en); echo ' ('.$g->notes.')' ?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
        
