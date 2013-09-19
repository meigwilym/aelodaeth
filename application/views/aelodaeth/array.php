<?php

/*
 * All current members 
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <header>
                <h5>Cyn Aelodau</h5>
                <div class="toolbar">
                    <a href="#" class="btn btn-inverse" id="changeHelp"><i class="icon-question-sign"></i> </a>
                </div>
            </header>
            <div class="body crchelp">
                <p>Dyma restr o bawb sydd wedi bod yn aelod ond sydd hab dalu am y tymor hwn. </p>
                <p>Mae'r golofn 'Hyd At' yn dangos pryd gorffenodd eu aelodaeth. </p>
                <p>Gellir trefnu pob colofn drwy glicio ar frig y golofn.  </p>
                <p>Gellir chwilio am aelod drwy deipio eu henw fewn i'r bwch 'Search'.</p>
            </div>
            <div class="body">
                
                <p>Rhestr sawl sydd <strong>heb</strong> dalu aelodaeth ar gyfer tymor <?=$tymor?></p>
                
                <p><?php echo anchor('admin/aelodaeth/atgoffa', '<i class="icon-envelope-alt"></i> Anfon ebost atgoffa');?></p>
                
                <table id="aelodau" class="table table-striped table-hover table-bordered table-condensed">
                    <thead> 
                    <tr>
                        <th>Rhif</th>
                        <th>Enw</th>
                        <th>Cyfeiriad</th>
                        <th>Tref</th>
                        <th>Cod Post</th>
                        <th>Ff&ocirc;n</th>
                        <th title="Dyddiad Ymuno">Ers</th>
                        <th title="Diwedd y Cyfnod Aelodaeth">Hyd At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($members as $m)
                    {
                        echo '<tr>';
                        
                        // id number
                        echo '<td>'.$m->id.'</td>';
                                                
                        // full name
                        echo '<td>'.anchor('admin/aelodaeth/edit/'.$m->id, $m->first_name.' '.$m->last_name).'</td>';
                        
                        // address
                        echo '<td>';
                        echo $m->billing_address1;
                        if($m->billing_address2) echo ', '.$m->billing_address2;
                        echo '</td>';
                        echo '<td>'.$m->billing_town.'</td>';
                        echo '<td>'.$m->billing_postcode.'</td>';
                        
                        // phone
                        echo '<td>'.$m->rhif_ffon.'</td>';
                        
                        // created on
                        echo '<td>'.printdate('d/n/y', $m->m_created_on).'</td>';
                        
                        // member until
                        echo '<td>'.printdate('Y', $m->ends_on).'</td>';
                        
                        // echo '<td>'.anchor('admin/aelodaeth/single/'.$m->id, '<i class="icon-edit"></i> ').'</td>';
                        
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    