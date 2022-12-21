window.onload = main;
function main()
{
    cridaApi();
}

function cridaApi()
{
    let usuario = document.getElementById('usuario');

    usuario.onchange = function () {
        let query = usuario.value;
        let apiUrl = '/api/v1/users/search?query=';
        
        let errMsg = '';
        let errField = document.getElementById('error-message');

        fetch(apiUrl+query,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then((response) => response.json())
        .then(data => {
            if(query === ''){
                usuario.setAttribute('class', 'form-control is-invalid');
                errMsg = "No es pot deixar el camp en blanc";
                let err = document.createTextNode(errMsg);
                errField.replaceChildren(err);
            } else {
                if(data.resultat === 'ok') {
                    usuario.setAttribute('class', 'form-control is-invalid');
                    errMsg = "Nom d'usuari registrat";
                    let err = document.createTextNode(errMsg);
                    errField.replaceChildren(err);
                } else {
                    usuario.setAttribute('class', 'form-control is-valid');
                }
            }
        })
    }
}