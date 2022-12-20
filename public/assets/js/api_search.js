window.onload = main;
function main()
{
    cridaApi();
}

function cridaApi()
{
    let usuario = document.getElementById('usuario');

    usuario.onchange = function () {
        let apiUrl = '/api/v1/users/search?query=';
        let query = usuario.value;

        fetch(apiUrl+query,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => response.json())
        .then(data => {
            if(data.resultat === 'ok')
            {
                usuario.setAttribute('class', 'form-control is-invalid');
            } else {
                usuario.setAttribute('class', 'form-control is-valid');
            }
        })
    }
}