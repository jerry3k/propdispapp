<script id='load_data' type='text/x-tmpl'>
{% for (var x=0; x<count(o); x++) { %}
<tr>
    <td>{%#'<a class="edit_job bold" data-id="'+o[x].id+'" title="Edit">'+o[x].jobcode +'</a>'%}</td>
    <td>{%#o[x].address1%}</td>
    <td>{%# my_datetime_formate( o[x].added_time, 'd-m-Y') %}</td>
    <td>
        <table class="table new_table table_alter mb0">
        <tbody id="tbody2_{%#o[x].id%}">
        {%
    let no = 1;
    let job_status = 'Pending';
    for(var j=0; j<count(o[x].subjobs); j++){
    let rowclass = '';
    if( isset(o[x].subjobs[j].job_status) && !empty(o[x].subjobs[j].job_status) ){
        job_status = 'Completed';
    rowclass = 'class="jrc"';
    }
    %}
                <tr {%#rowclass%} id="row_id_{%#o[x].subjobs[j].id%}">
                    <td>{%#no%}</td>
                    <td>{%#'<a class="edit_subjob bold" data-id="'+o[x].subjobs[j].id+'" data-jobid="'+o[x].subjobs[j].jobid+'">'+o[x].jobcode + '_' + o[x].subjobs[j].sort + '</a>' %}</td>
                    <td>{%#get_jobtype(o[x].subjobs[j].job_type)%}</td>
                    {% if(is_admin){ %}
                    <td>
                        <span>{%#'&pound;'+number_format(o[x].subjobs[j].total , 1)%} </span>
                    </td>
                    {% } %}
                    <td>{%# my_datetime_formate(o[x].enter_date , 'd-m-Y') %}</td>
                    <td>{%#job_status%}</td>
                </tr>
            {% no++; } %}
            </tbody>
        </table>
        <a class="btn_style subjob_modal" title="Add Job" data-id="{%=o[x].id%}">Add Job</a>
    </td>
</tr>
{% } %}





</script>


<script id='load_row_data' type='text/x-tmpl'>
{%  for (var x=0; x<count(o); x++) {
    let no = 1;
    let job_status = 'Pending';
    for(var j=0; j<count(o[x].subjobs); j++){
    let rowclass = '';
    if( isset(o[x].job_status) && !empty(o[x].job_status) ){
    job_status = 'Completed';
    rowclass = 'class="jrc"';
    }
        %}
<tr {%#rowclass%} id="row_id_{%#o[x].subjobs[j].id%}">
        <td>{%#no%}</td>
        <td>{%#o[x].jobcode + '_' + o[x].subjobs[j].sort%}</td>
        <td>{%#get_jobtype_description(o[x].subjobs[j].job_type)%}</td>
        {% if(is_admin){ %}
        <td>
            <span>{%#'&pound;'+number_format(o[x].subjobs[j].total , 1)%} </span>
        </td>
        {% } %}
        <td>{%# my_datetime_formate(o[x].enter_date , 'd-m-Y') %}</td>
        <td>{%#job_status%}</td>
</tr>
    {% no++; } %}
{% } %}





</script>


<script id='load_jobs_tab_data' type='text/x-tmpl'>

<div class="portlet">
    <div class="portlet-body">
{%
    for (var x=0; x<count(o); x++) {
    let id = o[x].id;

    // assign job values
    $( "#form1 input[name=id]" ).val( o[x].id );
    $('#form1 select#client_id').html('<option value="'+o[x].client_id+'">'+get_username(o[x].client_id)+'</option>').attr({
    "readonly": true,
    "style": "pointer-events: none",
    });

    $('#form1 #customer_name').val(o[x].customer_name);
    $('#form1 #autocomplete').val(o[x].address1);
    $('#form1 #locality').val(o[x].city);
    $('#form1 #postal_code').val(o[x].postcode);
    $('#form1 #street_number').val(o[x].address2);
    $('#form1 #latitude').val(o[x].latitude);
    $('#form1 #longitude').val(o[x].longitude);
    $('#form1 #country').val(o[x].country);
    $('#form1 #route').val(o[x].address3);


for(var j=0; j<count(o[x].subjobs); j++){

    let uid = uniqueID( 5 );
    let jobid = o[x].subjobs[j].id;
    let job_type = o[x].subjobs[j].job_type;
    let fitter_id = o[x].subjobs[j].fitter_id;
    let head_title = '';
    if(isset(o[x].subjobs[j].job_status) && !empty(o[x].subjobs[j].job_status)){
        head_title = 'head_title';
    }

    load_jobtype( '#job_type_' + jobid ,  job_type);
    get_tobtype_option(jobid , job_type , o[x].subjobs[j].print_name , o[x].subjobs[j].position);

    %}

        <div class="panel-group accordion" id="jobid_{%#jobid%}">
            <div class="panel panel-default">
                <div class="panel-heading {%#head_title%}">
                    <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled collapsed bold"
                           data-toggle="collapse" data-parent="#accordion_{%#jobid%}"
                           href="#collapse_{%=j%}_{%#jobid%}">
                            {%# o[x].jobcode + '_' + o[x].subjobs[j].sort%}
                            <span class="hdate">({%#o[x].subjobs[j].job_date%})</span>
                            {% if(isset(job_type) && !empty(job_type)){ %}
                            <span class="jtype">({%#get_jobtype_description(job_type)%})</span>
                            {% } %}
                            </a>
                    </h4>
                </div>
                <div id="collapse_{%=j%}_{%#jobid%}" class="panel-collapse collapse">
                    <div class="panel-body row-box">
                        <div class="row row-border jobrow_{%#jobid%}">

                            <div class="hidden">
                                <input name="eid[{%#jobid%}]" value="{%#jobid%}">
                                <input name="total[{%#jobid%}]" id="total_{%#jobid%}" value="{%#o[x].subjobs[j].total%}">
                                <input name="rowid[]"value="{%#jobid%}">
                                <input name="discount[{%#jobid%}]" value="{%#o[x].subjobs[j].discount%}">
                                <input name="price[{%#jobid%}]" data-id="{%#uid%}" data-parent_id="{%#jobid%}" value="{%#o[x].subjobs[j].price%}">
                                <input name="expense[{%#jobid%}]" data-id="{%#uid%}" data-parent_id="{%#jobid%}" value="{%#o[x].subjobs[j].expense%}">
                            </div>

                            <div class="col-md-12">
                                <div class="job-box">

                                    <div class="col-md-4">
                                        <label class="tl-color">Job Type <span
                                                class="rfield">*</span></label><select
                                            class="form-control change_jobtype valid"
                                            data-id="{%#jobid%}"
                                            name="job_type[{%#jobid%}]"
                                            id="job_type_{%#jobid%}"
                                            required="required">
                                        </select>
                                    </div>

                                    <div class="cjt-field_{%#jobid%}">

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="text"
                                                       name="job_date[{%#jobid%}]" readonly
                                                       class="form-control edited input-sm readonly" value="{%#o[x].subjobs[j].job_date%}"
                                                       placeholder="Select Date"><label>Date <span class="rfield">*</span></label>
                                            </div>
                                        </div>

                                        <div id="jobtype_option_{%#jobid%}"></div>

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="number"
                                                       name="qty[{%#jobid%}]"
                                                       data-id="{%#uid%}"
                                                       data-parent_id="{%#jobid%}"
                                                       class="form-control edited input-sm change_qty"
                                                       value="{%#o[x].subjobs[j].qty%}"
                                                       placeholder="Qty"><label>Qty</label>
                                            </div>
                                        </div>

                                    </div>

                                <div class="col-md-12 clearfix margin-tb-20 line-sperator"></div>

                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   class="form-control input-sm edited"
                                                   name="poref[{%#jobid%}]"
                                                   value="{%#o[x].subjobs[j].poref%}"
                                                   placeholder="PO/Ref Number"><label>PO/Ref
                                                Number</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="access[{%#jobid%}]"
                                                   value="{%#o[x].subjobs[j].access%}"
                                                   class="form-control input-sm edited"
                                                   placeholder="Access"><label>Access</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="keys_text[{%#jobid%}]"
                                                   value="{%#o[x].subjobs[j].keys_text%}"
                                                   class="form-control input-sm edited"
                                                   placeholder="Keys"><label>Keys</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="appointment[{%#jobid%}]"
                                                   value="{%#o[x].subjobs[j].appointment%}"
                                                   placeholder="Appointment"
                                                   class="form-control input-sm edited"><label>Appointment</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="board[{%#jobid%}]"
                                                   placeholder="No Board"
                                                   value="{%#o[x].subjobs[j].board%}"
                                                   class="form-control input-sm edited"><label>No
                                                Board</label></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="form-group form-md-line-input pt0 has-success">
                                            <textarea class="form-control"
                                                      name="comments[{%#jobid%}]"
                                                      rows="4"
                                                      placeholder="Your Comments...">{%#o[x].subjobs[j].comments%}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

{% }} %}

    </div>
</div>


















</script>