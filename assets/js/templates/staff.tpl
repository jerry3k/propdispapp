<script id='load_data' type='text/x-tmpl'>
{% for (var x=0; x<count(o); x++) {
    let status = '';
    let status_btn = '';
    if( empty( o[x].is_active ) ) {
        status_btn = '<button class="btn btn-xs red-pink tooltips status" data-id="'+o[x].id+'" data-is_active="1" title="Active user"><i class="fa fa-ban"></i></button>';
    } else {
        status_btn = '<button class="btn btn-xs green-meadow tooltips status" data-id="'+o[x].id+'" data-is_active="0" title="Deactive user"><i class="fa fa-check"></i></button>';
    }
    if( empty( o[x].is_login ) ) {
        status = '<span style="color:red">Not Login</span>';
    }else{
        status = '<span style="color:green">Activated</span>';
    }
    %}

    <tr id='row_id_{%=o[x].id%}'>
        <td>
         <div class="btn-group margin0">
            {%#status_btn%}
            <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' title="Delete User">
                <i class="fa fa-trash"></i></button>
                {% if(o[x].type != 'fitter'){ %}
                <button class="btn btn-xs yellow-casablanca tooltips send_email" data-id='{%=o[x].id%}' data-email='{%=o[x].email%}' title="Send Email">
                <i class="fa fa-envelope-o"></i></button>
                {% } %}
        </div>
        {%# '<a class="text_pre_line edit bold" data-id="'+o[x].id+'" title="Edit User">'+o[x].username+ '</a>'%}
        </td>
        <td>
            {%#o[x].email%}
        </td>
        <td>
            {%#o[x].phone%}
        </td>
        <td>
            <code>{%#ucwords(o[x].type)%}</code>
        </td>
        <td>
            {%#status%}
        </td>
    </tr>

{% } %}


</script>

<script id='load_row' type='text/x-tmpl'>
   {% for (var x=0; x<count(o); x++) {
    let status = '';
    let status_btn = '';
    if( empty( o[x].is_active ) ) {
        status_btn = '<button class="btn btn-xs red-pink tooltips status" data-id="'+o[x].id+'" data-is_active="1" title="Active user"><i class="fa fa-ban"></i></button>';
    } else {
        status_btn = '<button class="btn btn-xs green-meadow tooltips status" data-id="'+o[x].id+'" data-is_active="0" title="Deactive user"><i class="fa fa-check"></i></button>';
    }

    if( empty( o[x].is_login ) ) {
        status = '<span style="color:red">Not Login</span>';
    }else{
        status = '<span style="color:green">Activated</span>';
    }
    %}

        <td>
         <div class="btn-group margin0">
            {%#status_btn%}
            <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' title="Delete User">
                <i class="fa fa-trash"></i></button>
                {% if(o[x].type != 'fitter'){ %}
                <button class="btn btn-xs yellow-casablanca tooltips send_email" data-id='{%=o[x].id%}' data-email='{%=o[x].email%}' title="Send Email">
                <i class="fa fa-envelope-o"></i></button>
                {% } %}
        </div>
        {%# '<a class="text_pre_line edit bold" data-id="'+o[x].id+'" title="Edit User">'+o[x].username+ '</a>'%}
        </td>
        <td>
            {%#o[x].email%}
        </td>
        <td>
            {%#o[x].phone%}
        </td>
        <td>
            <code>{%#ucwords(o[x].type)%}</code>
        </td>
        <td>
            {%#status%}
        </td>

{% } %}

</script>