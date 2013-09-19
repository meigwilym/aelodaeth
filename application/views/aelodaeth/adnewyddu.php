<?php

    
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <header>
                <h5>Adnewyddu Aelodaeth</h5>
                <div class="toolbar">
                    <a href="#" class="btn btn-inverse" id="changeHelp"><i class="icon-question-sign"></i> </a>
                </div>
            </header>
            <div class="body">
                
                <h2><?php echo $member->first_name.' '.$member->last_name; ?></h2>
                <p>
                <?php 
                $sub_ends = (isset($subs->ends_on)) ? new DateTime($subs->ends_on) : $this->config->item('tymor_gorffen');
                
                if($sub_ends < $this->config->item('tymor_gorffen'))
                    echo 'Ddim yn aelod cyfredol. ';
                else
                    echo 'Aelod tan <strong class="badge badge-important">'.$sub_ends->format('j M, Y').'</strong>. ';
                
                $ends = $sub_ends->format('Y-m-d');
                ?>
                
                    Bydd yr aelodaeth newydd yn dechrau ar <strong class="badge badge-important"><?php echo $sub_ends->add(new DateInterval('P1D'))->format('j M, Y'); ?></strong>. </p>
                
                <?php echo validation_errors(); ?>
                
                <form action="" method="post" class="form form-horizontal">
                    <input type="hidden" name="member_id" value="<?php echo $member->id; ?>" />
                    <input type="hidden" name="status" value="paid" />
                    <input type="hidden" name="confirmed" value="1" />

                    <div class="control-group">
                        <label for="" class="control-label">Lefel Aelodaeth</label>
                        <div class="controls">
                            <?php 
                            foreach($types as $t): ?>
                            <label class="radio" for="type-<?php echo $t->id; ?>">
                            <input type="radio" name="membership_type_id" value="<?php echo $t->id; ?>" id="type-<?php echo $t->id; ?>"/> 
                            £<?php echo $t->amount; ?> &mdash; <?php echo $t->membership_type; ?> <span class="help-inline">[gorffen <?php 
                            $s_end = new DateTime($ends);
                            echo $s_end->add(new DateInterval('P'.$t->time_period.'Y'))->format('j M, Y');
                            
                            ?>]</span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="" class="control-label">Dull talu</label>
                        <div class="controls">
                            <select name="method">
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="notes" class="control-label">Nodiadau: </label>
                        <div class="controls span7">
                            <textarea name="notes" rows="3" style="width:350px"><?php echo set_value('notes', @$t->notes); ?></textarea>
                            <span class="help-block">Ar gyfer manylion; <acronym title="er enghraifft">e.e.</acronym> Rhif y chec, llyfr talu fewn <acronym title="ac yn y blaen">ayyb</acronym></span>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cadw</button>
                        &nbsp; neu <?php echo anchor('admin/aelodaeth/all', 'Canslo', array('rel'=>'tooltip', 'title'=>'Mynd yn ôl i\'r Rhestr Aelodaeth')); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        
