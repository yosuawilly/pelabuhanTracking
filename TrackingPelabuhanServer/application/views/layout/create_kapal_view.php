<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2><?php echo (isset($create))?'Create New Kapal':'Update Kapal'; ?></h2>
<!--    <h3><?php //echo 'Hello, Admin'; ?><br />
        <span></span>
    </h3>-->
    <?php echo form_open('home/submitKapal', array('class'=>'formfield')); ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="hidden" name="proses" value="<?php echo (isset($create))?'create':'update';?>"/>
    <fieldset>
        <legend>Detail Kapal</legend>
        <table>
            <tr class="odd">
                <td class="first">
                    <label>Kode Kapal</label>
                </td>
                <td class="last">:
                    <input type="text" name="kodekapal" value="<?php echo $kodekapal; ?>" <?=isset($update)?'readonly':''?> />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Nama Kapal</label>
                </td>
                <td>:
                    <input type="text" name="namakapal" value="<?php echo $namakapal; ?>" <?=isset($update)?'readonly':''?> />
                </td>
            </tr>
            <tr class="odd">
                <td class="first">
                    <label>Ukuran</label>
                </td>
                <td class="last">:
                    <input type="text" name="ukuran" value="<?php echo $ukuran; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Mesin</label>
                </td>
                <td>:
                    <input type="text" name="mesin" value="<?php echo $mesin; ?>"/>
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