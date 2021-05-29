window.onload= init; // appeler init une fois ma page chargée lancer js avec script en debut de html


function init()
{

    let buttons= Array.from(document.querySelectorAll('.like_button')); //transformer en tableau simple
    let serie_id= document.querySelector('#serie-id').value;
    console.log(serie_id);
    console.log(buttons);
    alert("ok");

    buttons.forEach( function (elem, idx){
        elem.addEventListener("click", function (){
            let data = {'serie_id': serie_id, 'like':elem.value};
            console.log(data);
            fetch("ajax-like", {method:'POST', body: JSON.stringify(data)})
                .then(function (response) {
                    return response.json()
                }).then(function (data){

                    // to do reponse issue du controller

                //console.log(data);
                document.querySelector('#nbreLike').innerHTML=data.likes; // avec likes, la table retournée de la method du controller



                })  ;// route où je veux aller , recuperer mes data en json
        });
    });
}

