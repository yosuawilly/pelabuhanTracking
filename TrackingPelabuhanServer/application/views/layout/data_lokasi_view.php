<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2><?php echo 'Data Lokasi Kapal'; ?></h2>
    
    <?php echo form_open('', array('class'=>'formfield')); ?>
    <input type="hidden" name="id" value="<?php //echo $id; ?>"/>
    <input type="hidden" name="proses" value="<?php //echo (isset($create))?'create':'update';?>"/>
    <fieldset>
        <legend>Pilih Kapal</legend>
        <table>
            <tr class="odd">
                <td class="first">
                    <label>Nama Kapal</label>
                </td>
                <td class="last">:
                    <!--<input type="email" name="kodekapal" value="" />-->
                    <select id="pilih-nama-kapal" name="namakapal" >
                        <?php foreach($kapals as $kapal) : ?>
                        <option value="<?=$kapal->kode_kapal?>" <?=($selected!=null)?($selected==$kapal->kode_kapal)?'selected':'':''?> >
                            <?=$kapal->nama_kapal?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br/>
        <?php if(isset($table)) echo $table; ?>
        <div style="float: right;">
            <?php if(isset($pagination)) echo $pagination; ?>
        </div>
        
        <?php if($error!=null) {?>
        <div id="pesanerror" style="width: 100%;"><?php echo ''.$error; ?></div><br/>
        <?php } ?>
        <button id="show-btn" type="submit" class="btn btn-primary">
            <i class="icon icon-search"></i> Show
        </button>
<!--        <button type="submit" name="batal" value="batal" class="btn btn-danger">
            <i class="icon icon-stop"></i> Batal
        </button>-->
    </fieldset>
    <?php echo form_close(); ?>
</div>