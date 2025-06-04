<script id='load_data' type='text/x-tmpl'>
{%  for (var x=0; x<count(o); x++) {

    let id = o[x].id;
    let jobid = o[x].jobid;
    let client_id = o[x].client_id;
    let jobtypeids = o[x].job_type_id;
    let jobtypehtml = '';
    jobtypeids = explode(',' , jobtypeids);
    for(var i=0; i<count(jobtypeids); i++){
    jobtypehtml += '<li>' + get_jobtype(jobtypeids[i]) + '</li>';
    }

    let qty = 0;
    let price = 0;
    let expense = 0;
    let total = 0;

    if(!empty(o[x].data)){
        let row = o[x].data;
        for(var j=0; j<count(row); j++){
            let ex = explode(',' , o[x].concat_id);
            if(in_array(row[j].id, ex)){
                qty = parseInt(qty) + parseInt(row[j].qty);
                price = parseFloat(price) + parseFloat(row[j].price);
                expense = parseFloat(expense) + parseFloat(row[j].expense);
                total = parseFloat(total) + parseFloat(row[j].total);
            }
        }
    }

    let dbtn = '';
    let invoice = '';
    let sr_no = o[x].invoice_no;

    if(!empty(sr_no)){
        sr_no = '#' + sr_no;
        invoice = o[x].invoice_no;
    }else{
        dbtn = 'disabled="disabled"';
        sr_no = '<button type="button" class="btn btn-xs green-dark generate_invoice" data-jobid="'+o[x].jobid+'" data-id="'+o[x].id+'" data-ids="'+o[x].concat_id+'"><i class="fa fa-refresh"> Generate</i></button>';
    }

    %}

    <tr id='row_id_{%#id%}'>
        <td id='td_invoice_{%#id%}'>{%#sr_no%}</td>
        <td>{%#'<a class="viewjob bold" data-id="'+id+'" data-jobid="'+jobid+'">'+get_username(client_id) + '&nbsp;<button class="btn btn-xs blue" title="'+o[x].count+' Jobs">' + o[x].count + '</button>' + '</a>'%}</td>
        <td>{%#jobtypehtml%}</td>
        <td>
             {%#o[x].count%} <br>
        </td>
        <td>
            <div class="btn-group margin0">
                <button {%#dbtn%} class="btn btn-xs red tooltips download gen_{%#id%}" data-invoice_no="{%#invoice%}" data-id="{%#id%}" data-jobid="{%#jobid%}" data-client_id="{%#client_id%}"  title="Download PDF">
                    <i class="fa fa-file-pdf-o"></i>
                </button>
                <button {%#dbtn%} class="btn btn-xs blue tooltips send gen_{%#id%}" data-email="{%#get_email(client_id)%}" data-invoice_no="{%#invoice%}" data-id="{%#id%}" data-jobid="{%#jobid%}" data-client_id="{%#client_id%}" title="Download PDF">
                    <i class="fa fa-envelope-o"></i>
                </button>
            </div>
        </td>
    </tr>

{% } %}





</script>

