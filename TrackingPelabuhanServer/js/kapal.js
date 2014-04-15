var Kapal = {
    getArrayKapal : function(response) {
        var kapals = [];

        try {

            for (var i=0; i<response.length; i++) {
                kapals.push(response[i].namakapal);
            }

        } catch(e) {
            alert(e);
        }

        return kapals;
    }
}