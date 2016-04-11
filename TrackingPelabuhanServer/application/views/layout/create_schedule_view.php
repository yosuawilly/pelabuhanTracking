<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2><?php echo (isset($create))?'Tambah Jadwal Baru':'Update Jadwal'; ?></h2>

    <?php echo form_open('home/submitSchedule', array('class'=>'formfield')); ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="hidden" name="proses" value="<?php echo (isset($create))?'create':'update';?>"/>
    <fieldset>
        <legend>Detail Jadwal</legend>
        <table>
            <tr class="odd">
                <td class="first">
                    <label>Kapal</label>
                </td>
                <td class="last">:
                    <select id="pilih-nama-kapal" name="kodekapal" >
                        <?php foreach($kapals as $kapal) : ?>
                            <option value="<?=$kapal->kode_kapal?>" <?=($kodekapal!=null)?($kodekapal==$kapal->kode_kapal)?'selected':'':''?> >
                                <?=$kapal->nama_kapal?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!--<input type="text" name="kodekapal" value="<?php /*echo $kodekapal; */?>" <?/*=isset($update)?'readonly':''*/?> />-->
                </td>
            </tr>
            <tr>
                <td>
                    <label>Dari</label>
                </td>
                <td>:
                    <input type="text" name="dari" value="<?php echo $dari; ?>" />
                </td>
            </tr>
            <tr class="odd">
                <td class="first">
                    <label>Ke</label>
                </td>
                <td class="last">:
                    <input type="text" name="ke" value="<?php echo $ke; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Jadwal Berangkat</label>
                </td>
                <td>:
                    <input type="datetime-local" name="jadwal_berangkat" value="<?php echo $jadwal_berangkat; ?>" required/>
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Jadwal Datang</label>
                </td>
                <td>:
                    <input type="datetime-local" name="jadwal_datang" value="<?php echo $jadwal_datang; ?>" required/>
                </td>
            </tr>
        </table><br/>
        <?php if($error!=null) {?>
            <div id="pesanerror" style="width: 100%;"><?php echo ''.$error; ?></div><br/>
        <?php } ?>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-plus"></i> Simpan
        </button>
        <button type="submit" name="batal" value="batal" class="btn btn-danger">
            <i class="icon icon-stop"></i> Batal
        </button>
    </fieldset>
    <?php echo form_close(); ?>
</div>