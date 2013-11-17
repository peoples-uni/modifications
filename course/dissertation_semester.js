M.dissertation_semester={

    Y : null,
    api: M.cfg.wwwroot+'/course/dissertation_semester_ajax.php',

    init : function(Y){
        this.Y = Y;
        Y.all('select.dissertationsemestermenu').each(this.attach_dissertationsemester_events, this);

        //hide the submit buttons
        this.Y.all('input.dissertationsemestermenusubmit').setStyle('display', 'none');
    },

    attach_dissertationsemester_events : function(selectnode) {
        selectnode.on('change', this.submit_dissertationsemester, this, selectnode);
    },

    submit_dissertationsemester : function(e, selectnode){
        var theinputs = selectnode.ancestor('form').all('.dissertationsemesterinput');
        var thedata = [];

        var inputssize = theinputs.size();
        for ( var i=0; i<inputssize; i++ )
        {
            thedata[theinputs.item(i).get("name")] = theinputs.item(i).get("value");
        }

        var scope = this;
        var cfg = {
            method: 'POST',
            on: {
                complete : function(tid, outcome, args) {
                    try {
                        if (!outcome) {
                            alert('IO FATAL');
                            return false;
                        }

                        var data = scope.Y.JSON.parse(outcome.responseText);
                        if (data.success){
                            return true;
                        }
                        else if (data.error){
                            alert(data.error);
                        }
                    } catch(e) {
                        alert(e.message+" "+outcome.responseText);
                    }
                    return false;
                }
            },
            arguments: {
                scope: scope
            },
            headers: {
            },
            data: build_querystring(thedata)
        };
        this.Y.io(this.api, cfg);

    }
};