<div id="main_content">
    <span class="emb_left"></span>
    <span class="emb_right"></span>
    <span class="emb_botleft"></span>
    <span class="emb_botright"></span>
    <span class="emb_footrpt"></span>
    <h2>Data Active Device</h2>
    <div style="padding-left: 10px; padding-right: 10px; overflow-x:auto;">
        <?php echo $table;?>
<!--        <hr />
        <div style="float: left;">
            <form style="padding: 0; margin: 0;" action="home/createKapal" method="post">
                <button type="submit" class="btn btn-primary">
                    <i class="icon icon-plus"></i> Tambah Kapal
                </button>
            </form>
        </div>-->
    </div>
</div>
<div id="konfirmasi-deactivate" style="display: none;">
            <center>
                <span>Apakah anda yakin deactivate device ini?</span>
            </center>
        </div>
<script type="text/javascript">
    function deleteData(a,kode_kapal){
        $("#konfirmasi-deactivate").dialog({
            title: "Konfirmasi",
            resizable: false,
            position: 'center',
            modal: true,
            width: 360,
            height: 140,
//            hide: 'fold',
            hide: 'explode',
            show: 'clip',
            buttons:[
                {
                    text:"Ok",
                    click:function(){
                        window.location.href = $(a).attr('href');
                    }
                },
                {
                    text:"Batal",
                    click:function(){
                        $(this).dialog("close");
                    }
                }
            ]
        });
        return false;
    }
</script>
