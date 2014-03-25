var Comet = function (data_url, handle_response) {
    this.timestamp = 0;
    this.url = data_url;  
    this.noerror = true;
    this.request = null;
    this.abort = false;
    
    if(typeof (handle_response) !== "function"){
        alert("Error, handle_response must be a function");
        return;
    }
    
    this.connect = function() {
        var self = this;

        self.request = $.ajax({
          type : 'get',
          url : this.url,
          dataType : 'json', 
          data : {'timestamp' : self.timestamp},
          success : function(response, status, xhr) {
            //self.timestamp = response.timestamp;
            self.handleResponse(response);
            self.noerror = true;          
          },
          complete : function(response) {
            if(self.abort) return;
            // send a new ajax request when this request is finished
            if (!self.noerror) {
              // if a connection problem occurs, try to reconnect each 5 seconds
              setTimeout(function(){ self.connect(); }, 5000);           
            }else {
              // persistent connection
              //self.connect();
              setTimeout(function(){ self.connect(); }, 1000);
            }

            self.noerror = false; 
          },
          error: function(xhr, status, errorMsg){
              //alert(errorMsg);
          }
        });
    };

    this.disconnect = function() {
        var self = this;
        if(self.request !== null) {
            self.abort = true;
            self.request.abort();
        }
    };

    this.handleResponse = typeof handle_response === 'function' ? handle_response : function(response) {
      $('#content').append('<div>' + response.msg + '</div>');
    };

    this.doRequest = function(request) {
        $.ajax({
          type : 'get',
          url : this.url,
          data : {'msg' : request, 'nameFile' : comet.nameFile}
        });
    };
};