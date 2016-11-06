function buscar2() {
    alert("soy un mensaje");
                event.preventDefault();
                var user_name = $("input#name").val();
                var password = $("input#pwd").val();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "busqueda/user_data_submit",
                    dataType: 'json',
                    data: {name: user_name, pwd: password},
                    success: function(res) {
                        if (res){
                            // Show Entered Value
                            jQuery("div#result").show();
                            jQuery("div#value").html(res.username);
                            jQuery("div#value_pwd").html(res.pwd);
                        }
                    }
                });

}
