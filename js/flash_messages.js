/* Prints flash messages at the top right of the page, it automatically disapears after 5 seconds */
/* Call the function you want in your JS File */

/* !!! Put the name of the resource in the first parameter (ie 'material'), and the id in the second */
/* !!! Include /css/flash_messages.css in your html */

function printSuccessMessage(resource, id)
{
    const flashMessage = document.createElement('div');
    flashMessage.classList.add('flash-message');
    flashMessage.classList.add('success');
    flashMessage.textContent = resource + ' n°' + id + ' correctement ajouté(e) !';

    document.body.appendChild(flashMessage);

    setTimeout(function() {
        flashMessage.remove();
    }, 5000);
}

function printErrorMessage(resource, id)
{
    const flashMessage = document.createElement('div');
    flashMessage.classList.add('flash-message')
    flashMessage.classList.add('error');
    flashMessage.textContent = resource + ' n°' + id + ' rencontre un problème !';

    document.body.appendChild(flashMessage);

    setTimeout(function() {
        flashMessage.remove();
    }, 5000);
}