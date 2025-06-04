<script id='load_data' type='text/x-tmpl'>
{%

    for (var x=0; x<count(o); x++) {
    let jobstatus = '';
    let jobstatusComplete = '';
    if(!empty(o[x].job_status)){
    jobstatusComplete = 'checked';
    jobstatus = '&nbsp;<span class="statusText'+o[x].id+'" style="color:green">Completed</span>';
    }else{
        jobstatus = '&nbsp;<span class="statusText'+o[x].id+'" style="color:red">Pending</span>';
    }

load_row_sticker( o[x].id );

    %}

    <tr id='row_id_{%=o[x].id%}'>
        <td>
            <div class="btn-group margin0 center">
                <button class="btn btn-xs blue tooltips edit" data-id='{%=o[x].id%}' title="Edit Job">
                <i class="fa fa-pencil"></i></button>
                <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' data-client_id='{%=o[x].client_id%}' title="Delete Job">
                <i class="fa fa-trash"></i></button>
            </div>
            <br><br>
            <b>Type : </b> {%=get_jobtype(o[x].job_type)%} <br>
            <code style='white-space: nowrap; float:left; font-size:15px;'>
                {%#o[x].jobcode%}
            </code>

        </td>
        <td>
            <b>Entered</b> : {%#mysql_date(o[x].job_date , 'd-m-Y')%} <br>
            <b>Completed </b>: {%#mysql_date(o[x].date_done , 'd-m-Y')%} <br>
            <label class="btn btn-xs tooltips pull-left" title="Job Status Change">
                <input {%#jobstatusComplete%} type="checkbox" name="job_status_change" data-id='{%=o[x].id%}' class="jobStatusChange">
                {%# jobstatus%}
            </label>
        </td>

        <td>
        <span class="job_sticker_{%=o[x].id%}"></span>
        </td>

        {% if(is_admin){ %}
            <td>
                {%=ucwords(get_username(o[x].fitter_id))%}
            </td>
        {% } %}
        <td>
            {%=o[x].postcode%}
        </td>
        <td>
            {%# o[x].address1 + ' <b>/</b> ' + o[x].city%}
        </td>
    </tr>

{% } %}




</script>

<script id='load_row' type='text/x-tmpl'>
   {%  for (var x=0; x<count(o); x++) {
    let jobstatus = '';
    let jobstatusComplete = '';
    if(!empty(o[x].job_status)){
    jobstatusComplete = 'checked';
    jobstatus = '&nbsp;<span class="statusText" style="color:green">Completed</span>';
    }else{
        jobstatus = '&nbsp;<span class="statusText" style="color:red">Pending</span>';
    }

    %}

      <td>
            <div class="btn-group margin0 center">
                <button class="btn btn-xs blue tooltips edit" data-id='{%=o[x].id%}' title="Edit Job">
                <i class="fa fa-pencil"></i></button>
                <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' data-client_id='{%=o[x].client_id%}' title="Delete Job">
                <i class="fa fa-trash"></i></button>
            </div>
            <br><br>
            <b>Type : </b> {%=get_jobtype(o[x].job_type)%} <br>
            <code style='white-space: nowrap; float:left; font-size:15px;'>
                {%#o[x].jobcode%}
            </code>

        </td>
        <td>
            <b>Entered</b> : {%#mysql_date(o[x].job_date , 'd-m-Y')%} <br>
            <b>Completed </b>: {%#mysql_date(o[x].date_done , 'd-m-Y')%} <br>
            <label class="btn btn-xs tooltips pull-left" title="Job Status Change">
                <input {%#jobstatusComplete%} type="checkbox" name="job_status_change" data-id='{%=o[x].id%}' class="jobStatusChange">
                {%# jobstatus%}
            </label>
        </td>

        <td>
        <span class="job_sticker_{%=o[x].id%}"></span>
        </td>

        {% if(is_admin){ %}
            <td>
                {%=ucwords(get_username(o[x].fitter_id))%}
            </td>
        {% } %}
        <td>
            {%=o[x].postcode%}
        </td>
        <td>
            {%# o[x].address1 + ' <b>/</b> ' + o[x].city%}
        </td>

{% } %}


</script>

<script id='sticker_row' type='text/x-tmpl'>

{% for (var x=0; x<count(o); x++) {
    let status = '';
    if(isset(o[x].status) && !empty(o[x].status)){
    status = 'checked="checked"';
    }

    %}

    <div class="row" id="row_{%=o[x].id%}">
        <div class="col-md-5">
            <input class="form-control" required="required" name="sticker[]" value="{%=o[x].sticker%}" placeholder="Name">
        </div>
        <div class="col-md-5">
            <input class="form-control" name="position[]" value="{%=o[x].position%}" placeholder="Position">
        </div>
        <div class="col-md-2">
            <div class="btn btn-group margin0">
                <input type="checkbox" {%#status%} name="sticker_status" value="0" data-id="{%=o[x].id%}" class="change_sticker_status checkbox_shap">
                <a class="dsticker" data-id="{%=o[x].id%}"><i class="fa fa-times f22"></i></a>
            </div>
        </div>
    </div>

       {% } %}


</script>





<script id='load_data111' type='text/x-tmpl'>
{%
    console.log(o);

    for (var x=0; x<count(o); x++) {
    let jobstatus = '';
    let jobstatusComplete = '';
    if(!empty(o[x].job_status)){
    jobstatusComplete = 'checked';
    jobstatus = '&nbsp;<span class="statusText'+o[x].id+'" style="color:green">Completed</span>';
    }else{
        jobstatus = '&nbsp;<span class="statusText'+o[x].id+'" style="color:red">Pending</span>';
    }

    %}

    <tr id='row_id_{%=o[x].id%}'>
        <td>
            <div class="btn-group margin0 center pull-right">
                <button class="btn btn-xs blue tooltips edit" data-id='{%=o[x].id%}' title="Edit Job">
                <i class="fa fa-pencil"></i></button>
                <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' data-client_id='{%=o[x].client_id%}' title="Delete Job">
                <i class="fa fa-trash"></i></button>
            </div>

            <br>
            <b>Type : </b> {%=get_jobtype(o[x].job_type)%} <br>
            <code style='white-space: nowrap; float:left; font-size:15px;'>
                {%#o[x].jobcode%}
            </code>

        </td>
        <td>
            <b>Entered</b> : {%#mysql_date(o[x].job_date , 'd-m-Y')%} <br>
            <b>Completed </b>: {%#mysql_date(o[x].date_done , 'd-m-Y')%} <br>
            <label class="btn btn-xs tooltips pull-left" title="Job Status Change">
                <input {%#jobstatusComplete%} type="checkbox" name="job_status_change" data-id='{%=o[x].id%}' class="jobStatusChange">
                {%# jobstatus%}
            </label>
        </td>
        <td>
            {%#mysql_date(o[x].job_date , 'd-m-Y')%}
        </td>
        <td>
            {%#mysql_date(o[x].date_done , 'd-m-Y')%}
        </td>
        <td>
            {%=get_jobtype(o[x].job_type)%}
        </td>
        {% if(is_admin){ %}
            <td>
                {%=ucwords(get_username(o[x].fitter_id))%}
            </td>
        {% } %}
        <td>
            {%=o[x].address1%}
        </td>
        <td>
            {%=o[x].postcode%}
        </td>
        <td>
            {%#o[x].city %}
        </td>
    </tr>

{% } %}




</script>