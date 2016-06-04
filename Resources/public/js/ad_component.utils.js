/**
 * Created by claudio on 04-06-16.
 */
var ADComponent = {
    msgAlert : function (status, msg) {
          return '<div class="alert alert-'+ status +' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+ msg + '</div>';
    },
};