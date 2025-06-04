<script id='load_data' type='text/x-tmpl'>
{% for (var x=0; x<count(o); x++) {
    let status = '';
    let status_btn = '';
    let discount = 0;

    if( empty( o[x].status ) ) {
        status = '<span style="color:red">Deactive</span>';
        status_btn = '<button class="btn btn-xs red-pink tooltips status" data-id="'+o[x].id+'" data-status="1" title="Active"><i class="fa fa-ban"></i></button>';
    } else {
        status = '<span style="color:green">Active</span>';
        status_btn = '<button class="btn btn-xs green-meadow tooltips status" data-id="'+o[x].id+'" data-status="0" title="Deactive"><i class="fa fa-check"></i></button>';
    }

    if( !empty(o[x].discount) ){
        discount = o[x].discount;
    }

    %}

    <tr id='row_id_{%=o[x].id%}'>

    <td>{%=ucwords(o[x].name)%}</td>
    <td>{%#o[x].description%}</td>
    <td>{%=o[x].price_a%}</td>
    <td>{%=o[x].price_b%}</td>
    <td>{%#discount%}</td>
    <td>{%#status%}</td>
    <td>
        <div class="btn-group margin0">
        {%#status_btn%}
        <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' title="Delete">
            <i class="fa fa-trash"></i></button>
        <button class="btn btn-xs blue tooltips edit" data-id='{%=o[x].id%}' title="Edit">
            <i class="fa fa-pencil"></i></button>
        </div>
    </td>
    </tr>

{% } %}




</script>


<script id='load_row' type='text/x-tmpl'>
    {% for (var x=0; x<count(o); x++) {
    let status = '';
    let status_btn = '';
    let discount = 0;
    if( empty( o[x].status ) ) {
    status = '<span style="color:red">Deactive</span>';
    status_btn = '<button class="btn btn-xs red-pink tooltips status" data-id="'+o[x].id+'" data-status="1" title="Active"><i class="fa fa-ban"></i></button>';
    } else {
        status = '<span style="color:green">Active</span>';
        status_btn = '<button class="btn btn-xs green-meadow tooltips status" data-id="'+o[x].id+'" data-status="0" title="Deactive"><i class="fa fa-check"></i></button>';
    }

     if( !empty(o[x].discount) ){
        discount = o[x].discount;
    }

    %}

    <td>{%=ucwords(o[x].name)%}</td>
    <td>{%#o[x].description%}</td>
    <td>{%=o[x].price_a%}</td>
    <td>{%=o[x].price_b%}</td>
    <td>{%#discount%}</td>
    <td>{%#status%}</td>
    <td>
        <div class="btn-group margin0">
        {%#status_btn%}
        <button class="btn btn-xs red tooltips delete" data-id='{%=o[x].id%}' title="Delete">
            <i class="fa fa-trash"></i></button>
        <button class="btn btn-xs blue tooltips edit" data-id='{%=o[x].id%}' title="Edit">
            <i class="fa fa-pencil"></i></button>
        </div>
    </td>

    {% } %}


</script>