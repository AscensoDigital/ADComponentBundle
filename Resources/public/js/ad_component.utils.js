/**
 * Created by claudio on 04-06-16.
 */
var ADComponent = {
    msgAlert : function (level, msg) {
          return '<div class="alert alert-'+ level +' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+ msg + '</div>';
    },

    msgLabel: function (label, level, msg) {
        var clase = "label label-" + level;
        return '<span class="' + clase + '">' + label + '</span><br><div>' + msg + '</div>';
    },

    object2Array: function (obj) {
        var ret= {};
        for (var prop in obj) {
            console.log(prop+' '+obj[prop]);
            if(typeof(obj[prop])=='object'){
                ret[prop]=objectToArray(obj[prop]);
            }
            else {
                ret[prop]=obj[prop];
            }
            console.log(ret);
        }
        return ret;
    }
};