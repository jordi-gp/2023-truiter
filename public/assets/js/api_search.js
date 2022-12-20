window.onload = main;
function main()
{
    cridaApi();
}

function cridaApi()
{
    let usuario = document.getElementById('usuario');

    console.log('funciona');
    console.log(usuario);
    usuario.onchange = function () {
        console.log(usuario.value);

        fetch('/api/v1/users/search?query='+usuario.value,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => response.json())
        .then(function(data){
            console.log(data);
        })


    }
}