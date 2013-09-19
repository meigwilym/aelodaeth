<?php

/*
 * All current members 
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <header>
                <h5>Aelodau Cyfredol</h5>
                <div class="toolbar">
                    <a href="#" class="btn btn-inverse" id="changeHelp"><i class="icon-question-sign"></i> </a>
                </div>
            </header>
            <div class="body crchelp">
                <p>Dyma restr o bob aelod cyfredol. </p>
                <p>Mae'r golofn 'Hyd At' yn dangos tan pryd mae eu aelodaeth yn para. </p>
                <p>Gellir trefnu pob colofn drwy glicio ar frig y golofn.  </p>
                <p>Gellir chwilio am aelod drwy deipio eu henw fewn i'r bwch 'Search'.</p>
            </div>
            <div class="body">
                
                <p>Rhestr o'r aelodau cyfredol. </p>
                
                <table id="aelodau" class="table table-striped table-hover table-bordered table-condensed">
                    <thead> 
                    <tr>
                        <th title="Rhif unigryw">Rhif</th>
                        <th title="Enw Llawn">Enw</th>
                        <th title="Dwy linell gyntaf y cyfeiriad">Cyfeiriad</th>
                        <th title="Tref">Tref</th>
                        <th title="Cod Post">Cod Post</th>
                        <th title="Rhif Ffon">Ff&ocirc;n</th>
                        <th title="Dyddiad Ymuno">Ers</th>
                        <th title="Diwedd y Cyfnod Aelodaeth">Hyd At</th>
			<th title="Dyddiad y taliad diweddaraf">Talu</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($members as $m)
                    {
                        $row_class = $m->status;
                        if($m->status == 'pending') $row_class = 'warning';
                        
                        echo '<tr class="'.$row_class.'">';
                        
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
						// <!-- '.printdate('Ymd', $m->m_created_on).' --> '.
						
                        // member until
                        echo '<td>'.printdate('Y', $m->ends_on).'</td>';
                        
			echo '<td><!-- '.printdate('Ymd', $m->created_on).' --> '.printdate('d/n', $m->created_on).'</td>';
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
    