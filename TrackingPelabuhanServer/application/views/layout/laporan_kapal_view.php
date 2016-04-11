<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2>Laporan Kapal</h2>

    <?php echo form_open('', array('class'=>'formfield')); ?>
    <fieldset>
        <legend style="display: block;">Pilih Kapal</legend>
        <table style="display: block;">
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

        <?php if ($total_rows > 0) { ?>
            <b>Keterangan :</b> <br/>
            <div><div class="bullet_n" style="background-position: 0px 2px;"></div><span> : Data baru / Belum berangkat</span></div>
            <div><div class="bullet_o" style="background-position: 0px 2px;"></div><span> : Dalam perjalanan</span></div>
            <div><div class="bullet_l" style="background-position: 0px 2px;"></div><span> : Terlambat</span></div>
            <div><div class="bullet_a" style="background-position: 0px 2px;"></div><span> : Sudah Tiba</span></div>
            <br/>
        <?php } ?>

        <button id="show-btn" type="submit" class="btn btn-primary">
            <i class="icon icon-search"></i> Show
        </button>
    </fieldset>
    <?php echo form_close(); ?>

    <!--<div style="padding-left: 10px; padding-right: 10px; overflow-x:auto;">

    </div>-->
</div>