$.ajax({
    url: "http://localhost/lib/ramais.php",
    type: "get",
    ajax:'1',
    success: function(data){                
              for(let i in data){
          if (data[i].status == 'indisponivel'){  
                        $('#cartoes').append(`<div class="cartao-indisponivel">
                                        <div>${data[i].nome }</div>
                                        <div>${data[i].ramal }</div>                                        
                                         <span class="${data[i].status} icone-posicao"></span>                                                                 
                                       </div>`)                            
            }
            else{
                $('#cartoes').append(`<div class="cartao">
                                     <div>${data[i].nome }</div>
                                     <div>${data[i].ramal }</div>
                                      <span class="${data[i].status} icone-posicao"></span>
                                    
                                 </div>`)
            }           
        }
    },
    error: function(){
        console.log("Errouu!")
    }
});