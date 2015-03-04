jQuery(document).ready(function(){
    jQuery("#response_option").change(function() {
        if (jQuery( this).val() === 'http' ){
            jQuery("#response_url").show();
            jQuery("#response_ajax").hide();
        }else{
            jQuery("#response_url").hide();
            jQuery("#response_ajax").show();
        }
    });
    
    jQuery(".form-table").on('click', ".new_row",function() {
        var id = jQuery(".form-table tr:last-child").attr("id");
        id++;
        jQuery(".form-table").append(jQuery(".fields_row_empy").clone());
        jQuery(".form-table .fields_row_empy").addClass("fields_row");
        jQuery(".form-table .fields_row_empy").removeClass("fields_row_empy");
        jQuery(".form-table tr:last-child").attr("id", id);
        jQuery(".form-table tr:last-child > th > label").text('Campo ' + id);
    });
    
    jQuery(".form-table").on('click', ".delete_row",function() {
        var id =jQuery(this).parent().parent().attr("id");
        jQuery("#" + id).remove();
    });
});