function llenarlistboxbancosus(resp) {
        $.ajax({
            url: 'Bancos/listabancosComboBox',
            dataType: 'json',
            type:'POST',
             beforeSend: function(){ if (resp=="x"){
                    $('#list-banco').html("<img src='img/ajaxload2.gif'>");}
                else{
                    $('#list-editbanco').html("<img src='img/ajaxload2.gif'>");
                }},
            success: function(data) {
               if(data!=""){
                    var list =""; 
                    if (resp=="x") {
                        list = '<select id="select-banco"><option value="">Seleccione un Banco</option>';
                    }else{
                        list ='<select id="select-editbanco">';
                    }     
                    $.each(data, function(item) {
                        var idBanco = data[item].Banco.id;
                        var banconom = data[item].Banco.banco;
                        if(resp==idBanco){ 
                            list += '<option selected=selected value=' + idBanco + '>' + banconom + '</option>';
                        }else{
                            list += '<option value=' + idBanco + '>' + banconom + '</option>';
                        }                       
                    });
                    list += '</select>';
                    if (resp=="x") {
                        $('#list-banco').html(list);
                    }else{
                        $('#list-editbanco').html(list);
                    }
                }else{
                    var list = '<select id="select-edittcbancariasegoria"><option>No hay bancos en la BD</option>';
                    if (resp=="x"){
                         $('#list-banco').html(list);
                    }else{
                         $('#list-editbanco').html(list);
                    }
                }
               }
         });
    }
    function llenarlistboxtcbancos(resp,idcat) {
        $.ajax({
            url: 'TipoCuentasBancarias/listatcbancariasComboBox/'+idcat,
            dataType: 'json',
            type:'POST',
            beforeSend: function(){ 
                if (resp=="x"){
                    $('#list-tcbanco').html("<img src='img/ajaxload2.gif'>");}
                else{
                    $('#list-edittcbanco').html("<img src='img/ajaxload2.gif'>");
                }},
            success: function(data) {                    
                    if(data!=""){
                        var list =""; 
                        if (resp=="x") {
                            list = '<select id="select-tcbanco" name="tipo_cuentas_bancaria_id"><option value="">Seleccione una Cuenta</option>';
                        }else{
                            list ='<select id="select-edittcbanco" name="tipo_cuentas_bancaria_id">';
                        }     
                        $.each(data, function(item) {                                                    
                            if(resp==data[item].TipoCuentasBancaria.id){ 
                                list += '<option selected=selected value=' + data[item].TipoCuentasBancaria.id + '>' + data[item].TipoCuentasBancaria.tipoCuentaBancaria + '</option>';
                                llenarlistboxbancosus(data[item].TipoCuentasBancaria.banco_id);
                            }
                            else{
                                list += '<option value=' +  data[item].TipoCuentasBancaria.id + '>' + data[item].TipoCuentasBancaria.tipoCuentaBancaria + '</option>';
                            }                       
                        });
                        list += '</select>';
                        if (resp=="x") {
                            $('#list-tcbanco').html(list);
                        }else{
                            $('#list-edittcbanco').html(list);
                        }
                    }else{
                        var list = '<select id="select-edittcbanco"><option>No hay Cuentas en la BD</option>';
                        if (resp=="x") {
                            $('#list-tcbanco').html(list);
                        }else{
                            $('#list-edittcbanco').html(list);
                        }
                    }
               }
         });
    }
    
    