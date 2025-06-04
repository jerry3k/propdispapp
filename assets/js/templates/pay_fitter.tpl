<script id='load_data' type='text/x-tmpl'>
{%
    let total = 0;
    for (var x=0; x<count(o); x++) {

    let company_name = '';
    company_name = get_username(o[x].client_id);
    company_name = company_name.replace(/[0-9]/g, '');
    company_name = company_name.replace("_", " ");
    company_name = company_name.replace(/_/g, ' ');

    total += o[x].price;
    %}

    <tr id='row_id_{%=o[x].id%}'>
        <td>
             {%=get_username(o[x].fitter_id)%}
        </td>
        <td>
             {%=company_name%}
        </td>
        <td>
            {%=get_jobtype(o[x].job_type)%}
        </td>
        <td>
            {%=my_datetime_formate(o[x].invoice_date , 'd-m-Y')%}
        </td>
        <td>
            {%=getSticker(o[x].job_id)%}
        </td>
        <td>
            {%=getJobAddress(o[x].job_id)%}
        </td>
        <td>
            {%=getJobPostCode(o[x].job_id)%}
        </td>
        <td>
            &pound;{%=number_format(o[x].price , 2)%}
        </td>
    </tr>

{% }


$('#total_price').html('<b>&pound;'+number_format(total , 2)+'</b>');
%}



</script>

