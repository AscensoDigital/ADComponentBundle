/**
 * Created by claudio on 04-06-16.
 */
var ADComponent = {
    msgAlert : function (level, msg) {
          return '<div class="alert alert-'+ level +' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> '+ msg + '</div>';
    },

    msgLabel: function (label, level, msg) {
        var label = "label label-" + level;
        return "<span class='" + label + "'>" + label + "</span><br><div>" + msg + "</div>";
    },
};