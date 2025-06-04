<script id='load_jobs' type='text/x-tmpl'>
{% for (var x=0; x<count(o); x++) {
    let status = '';
    let checked = '';
    if(isset(o[x].job_status) && !empty(o[x].job_status)){
    status = 'jrc';
    checked = 'checked="checked"';
    }

    %}
    <tr class="rowid_{%=o[x].id%} {%#status%}">
        <td>
            {%#'<div class="btn-group"><a class="btn btn-xs blue" target="_blank" title="View as Client Page" href="'+DOMAIN_URL+'jobs/client/'+o[x].client_id+'"><i class="fa fa-external-link"></i></a><button class="btn btn-xs red deletejob" data-id="'+o[x].id+'" data-jobid="'+o[x].jobid+'"><i class="fa fa-trash"></i></button>'+
    '<input type="checkbox" '+checked+' name="job_status['+o[x].id+']" class="update_job_status check-scale done_job_'+o[x].id+'" data-id="'+o[x].id+'" data-jobid="'+o[x].jobid+'" data-jobtype="'+o[x].job_type+'" data-client_id="'+o[x].client_id+'" value="1">'
    +'</div>'
    +'<a class="p5px edit_job bold text_pre_line" data-id="'+o[x].id+'" data-jobid="'+o[x].jobid+'">'+o[x].jobcode + '_' + o[x].sort + '</a>' %}
        </td>
        <td>{%#get_jobtype_description(o[x].job_type)%}</td>
        <td>{%#o[x].print_name%}</td>
        <td>{%#o[x].position%}</td>
        <td>{%#mysql_date(o[x].job_date)%}</td>
        <td>{%#get_username(o[x].fitter_id)%}</td>
        <td>{%#o[x].postcode%}</td>
        <td>{%#o[x].address1%}</td>
        <td>{%#o[x].qty%}</td>
    </tr>
{% } %}

</script>

<script id='load_jobs_tab_data' type='text/x-tmpl'>

<div class="portlet">
    <div class="portlet-body">
{%
    for (var x=0; x<count(o); x++) {
    let id = o[x].id;
    let uid = uniqueID( 5 );
    let job_type = o[x].job_type;
    let fitter_id = o[x].fitter_id;
    let head_title = '';
    if(isset(o[x].job_status) && !empty(o[x].job_status)){
    head_title = 'head_title';
    }
    // assign job values
    $( "#form1 input[name=id]" ).val( o[x].jobid );
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

    load_jobtype( '#job_type_' + id ,  job_type);
    load_fitter_users( '#fitter_id_' + uid , fitter_id );
    get_tobtype_option(id , job_type , o[x].print_name , o[x].position);
    %}
        <div class="panel-group accordion" id="jobid_{%# o[x].id %}">
            <div class="panel panel-default">
                <div class="panel-heading {%#head_title%}">
                    <h4 class="panel-title">
                        <a class="accordion-toggle accordion-toggle-styled collapsed bold"
                           data-toggle="collapse" data-parent="#accordion_{%#o[x].id%}"
                           href="#collapse_{%=x%}_{%#o[x].id%}">
                            {%# o[x].jobcode + '_' + o[x].sort%}
                            <span class="hdate">({%#o[x].job_date%})</span>
                            <span class="jtype">({%#get_jobtype_description(o[x].job_type)%})</span>
                            </a>
                    </h4>
                </div>
                <div id="collapse_{%=x%}_{%#o[x].id%}" class="panel-collapse collapse">
                    <div class="panel-body row-box">
                        <div class="row row-border jobrow_{%#o[x].id%}">
                            <div class="hidden">
                            <input name="eid[{%#o[x].id%}]" value="{%#o[x].id%}">
                            <input name="total[{%#o[x].id%}]" id="total_{%#o[x].id%}" value="{%#o[x].total%}">
                            <input name="rowid[]"value="{%#o[x].id%}"></div>
                            <div class="col-md-12" style="display:inline-block;">
                                <a class="pointer btn btn-sm deletejob red pull-right" data-id="{%#o[x].id%}
    " data-jobid="{%#o[x].jobid%}" title="Delete Job"><i
                                    class="fa fa-times"></i>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="job-box">

                                    <div class="col-md-4">
                                        <label class="tl-color">Job Type <span
                                                class="rfield">*</span></label><select
                                            class="form-control change_jobtype valid"
                                            data-id="{%#o[x].id%}"
                                            name="job_type[{%#o[x].id%}]"
                                            id="job_type_{%#o[x].id%}"
                                            required="required">
                                        </select>
                                    </div>

                                    <div class="cjt-field_{%#o[x].id%}">

                                        <div class="col-md-2 hidden">
                                            <input name="discount[{%#o[x].id%}]" value="{%#o[x].discount%}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="tl-color">Select
                                                    Fitter <span class="rfield">*</span>
                                            </label>
                                                <select name="fitter_id[{%#o[x].id%}]"
                                                id="fitter_id_{%#uid%}"
                                                class="form-control"
                                                required="required">
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="text"
                                                       name="job_date[{%#o[x].id%}]"
                                                       class="form-control edited input-sm date-picker" value="{%#o[x].job_date%}"
                                                       placeholder="Select Date"><label>Date Enter<span class="rfield">*</span></label>
                                            </div>
                                        </div>

                                        <div id="jobtype_option_{%#o[x].id%}"></div>

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="number"
                                                       name="price[{%#o[x].id%}]"
                                                       data-id="{%#uid%}"
                                                       data-parent_id="{%#o[x].id%}" value="{%#o[x].price%}"
                                                       class="form-control edited input-sm change_price"
                                                       placeholder="Price">
                                                       <label>Price</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="number"
                                                       name="qty[{%#o[x].id%}]"
                                                       data-id="{%#uid%}"
                                                       data-parent_id="{%#o[x].id%}"
                                                       class="form-control edited input-sm change_qty"
                                                       value="{%#o[x].qty%}"
                                                       placeholder="Qty"><label>Qty</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div
                                                class="form-group form-md-line-input has-success">
                                                <input type="number"
                                                       name="expense[{%#o[x].id%}]"
                                                       data-id="{%#uid%}"
                                                       value="{%#o[x].expense%}"
                                                       data-parent_id="{%#o[x].id%}"
                                                       class="form-control edited input-sm change_expense"
                                                       placeholder="Expense"><label>Expense</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 clearfix margin-tb-20 line-sperator"></div>

                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   class="form-control input-sm edited"
                                                   name="poref[{%#o[x].id%}]"
                                                   value="{%#o[x].poref%}"
                                                   placeholder="PO/Ref Number"><label>PO/Ref
                                                Number</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="access[{%#o[x].id%}]"
                                                   value="{%#o[x].access%}"
                                                   class="form-control input-sm edited"
                                                   placeholder="Access"><label>Access</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="keys_text[{%#o[x].id%}]"
                                                   value="{%#o[x].keys_text%}"
                                                   class="form-control input-sm edited"
                                                   placeholder="Keys"><label>Keys</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="appointment[{%#o[x].id%}]"
                                                   value="{%#o[x].appointment%}"
                                                   placeholder="Appointment"
                                                   class="form-control input-sm edited"><label>Appointment</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input type="text"
                                                   name="board[{%#o[x].id%}]"
                                                   placeholder="No Board"
                                                   value="{%#o[x].board%}"
                                                   class="form-control input-sm edited"><label>No
                                                Board</label></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="form-group form-md-line-input pt0 has-success">
                                            <textarea class="form-control"
                                                      name="comments[{%#o[x].id%}]"
                                                      rows="4"
                                                      placeholder="Your Comments...">{%#o[x].comments%}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="job-box">
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input
                                                class="form-control date-picker input-sm editable"
                                                type="text"
                                                name="date_to_be_done[{%#o[x].id%}]"
                                                data-date-format="dd-mm-yyyy"
                                                value="{%#my_date(o[x].date_to_be_done)%}"
                                                placeholder="DateToBeDone"><label>DateToBeDone
                                                <span
                                                    class="rfield">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4"><label
                                            class="tl-color">Contact
                                            <span class="rfield">*</span></label>
                                            <select class="form-control"
                                            name="contact_type[{%#o[x].id%}]">
                                            <option value="email" {% if(isset(o[x].contact_type) && o[x].contact_type == 'email'){ %}
     selected {% } %}>Email</option>
                                            <option value="phone" {% if(isset(o[x].contact_type) && o[x].contact_type == 'phone'){ %}
     selected {% } %}>Phone</option>
                                        </select></div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success">
                                            <input
                                                class="form-control input-sm edited"
                                                type="text"
                                                name="client_contact[{%#o[x].id%}]"
                                                value="{%#o[x].client_contact%}"
                                                placeholder="Client Contact Name/Notes"><label>CC
                                                Name/Notes</label></div>
                                    </div>
                                    <div class="col-md-12 clearfix margin-tb-20 line-sperator"></div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success pt0">
                                            <label><input type="checkbox"
                                                          name="espc[{%#o[x].id%}]"
                                                          value="true"
                                                          {% if(isset(o[x].espc) && o[x].espc == "true"){ %}
     checked="checked" {% } %}>ESPC
                                                Placard</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success pt0">
                                            <label><input type="checkbox"
                                                          name="charge[{%#o[x].id%}]" value="true"
                                                          {% if(isset(o[x].charge) && o[x].charge == "true"){ %}
     checked="checked" {% } %}>Charge</label>
                                                          <label>
                                                          <input
                                                    type="checkbox"
                                                    name="pay[{%#o[x].id%}]"
                                                    value="true"
                                                    {% if(isset(o[x].pay) && o[x].pay == "true"){ %}
     checked="checked" {% } %}
                                                    >Pay</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input pt0 has-success">
                                            <input type="text"
                                                   name="questionmark[{%#o[x].id%}]"
                                                   value="{%#o[x].questionmark%}"
                                                   class="form-control input-sm questionmark"
                                                   placeholder="?"></div>
                                    </div>


                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success pt0">
                                            <label>Job Status</label>
                                            <div class="jobstatus-btn">
                                                <label><input type="radio"
                                                              data-id="{%#o[x].id%}"
                                                              name="job_status[{%#o[x].id%}]"
                                                              value="0"
                                                              class="change_job_status"
                                                              {% if(isset(o[x].job_status) && o[x].job_status == "0"){ %}
     checked="checked" {% } %}
                                                              >Pending</label><label><input
                                                        type="radio"
                                                        data-id="{%#o[x].id%}"
                                                        name="job_status[{%#o[x].id%}]"
                                                        value="1"
                                                        class="change_job_status"
                                                        {% if(isset(o[x].job_status) && o[x].job_status == "1"){ %}
     checked="checked" {% } %}
                                                        >Done</label>
                                                <div class="js-date_{%#o[x].id%}"
                                                {% if(isset(o[x].job_status) && o[x].job_status == "1"){ %}
     style="display: block;" {% }else{ %} style="display: none;" {% } %}>
                                                    <input
                                                        class="form-control form-control-inline date-picker input-sm"
                                                        size="16"
                                                        name="date_done[{%#o[x].id%}]"
                                                        id="date_done_{%#o[x].id%}"
                                                        type="text" value="{%#my_date(o[x].date_done)%}"
                                                        data-date-format="dd-mm-yyyy"
                                                        required="required"
                                                        placeholder="Select Date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success pt0">
                                            <label>Deliver Own Over
                                                plate</label>
                                            <div class="deliver-plate">
                                                <label><input type="radio"
                                                              name="overplate[{%#o[x].id%}]"
                                                              value="blank"
                                                              {% if(isset(o[x].overplate) && o[x].overplate == "blank"){ %}
     checked="checked" {% } %}
                                                              >Blank</label><label><input
                                                        type="radio"
                                                        name="overplate[{%#o[x].id%}]"
                                                        value="yes"
                                                        {% if(isset(o[x].overplate) && o[x].overplate == "yes"){ %}
     checked="checked" {% } %}
                                                        >Yes</label><label>
                                                        <input type="radio"
                                                        name="overplate[{%#o[x].id%}]"
                                                        {% if(isset(o[x].overplate) && o[x].overplate == "delivered"){ %}
     checked="checked" {% } %}
                                                        >Delivered</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div
                                            class="form-group form-md-line-input has-success pt0">
                                            <label>
                                                <input type="checkbox" class="change_pro_status" data-id="{%#o[x].id%}" name="lost_property[{%#o[x].id%}]" value="true"
                                                          {% if(isset(o[x].lost_property) && o[x].lost_property == "true"){ %}
                                                                checked="checked"
                                                          {% } %}
                                                          >Lost Property
                                                </label>

                                                <div class="lost-job lost_pro_option_{%#o[x].id%}">
                                                {% if(isset(o[x].lost_property) && o[x].lost_property == "true"){ %}

                                                <label><input type="radio" name="lost[{%#o[x].id%}]" value="pole" required="required"
                                                {% if(isset(o[x].lost_type) && o[x].lost_type == "pole"){ %}
     checked="checked" {% } %}
                                                >Pole</label>
                                                <label><input type="radio" name="lost[{%#o[x].id%}]" value="board"
                                                 {% if(isset(o[x].lost_type) && o[x].lost_type == "board"){ %}
     checked="checked" {% } %}
                                                >Board</label>
                                                <label><input type="radio" name="lost[{%#o[x].id%}]" value="both"
                                                {% if(isset(o[x].lost_type) && o[x].lost_type == "both"){ %}
     checked="checked" {% } %}
                                                >Both</label>

                                                {% } %}

                                                </div>

                                                </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div
                                            class="form-group form-md-line-input pt0 has-success">
                                            <textarea class="form-control"
                                                      name="internal_comments[{%#o[x].id%}]"
                                                      rows="4"
                                                      placeholder="Problems/ Internal comments">{%#o[x].internal_comments%}</textarea>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-12 clearfix margin-tb-20 line-sperator"></div>
                                    <div class="col-md-4"><span
                                            class="tl-color">Price :</span>
                                        <p class="job-total-price_{%#o[x].id%}">
                                            £{%#o[x].price%}</p></div>
                                    <div class="col-md-4"><span
                                            class="tl-color">Adjustment : </span>
                                        <p class="job-expense-price_{%#o[x].id%}">
                                            £{%#o[x].expense%}</p></div>
                                    <div class="col-md-4"><span
                                            class="tl-color">Total : </span>
                                        <p class="all-total-price_{%#o[x].id%}">
                                            £{%#o[x].total%}</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{% } %}

    </div>
</div>

</script>
