window.onload = function(){
    /// USERS ///
    var user;
    document.getElementById("userList").onchange = function () {

        getUser(document.getElementById("userList").value);
        debugger;
        document.getElementById("profilList").value = user['profil_id'];
    };

    function getUser(userId) {
        var url = '/utilisateur/' + userId ;
        $.ajax({
            method: 'GET',
            url: url,
            async: false,
            dataType: "json",
            success: function (data) {
                user = data;
            },
            error: function () {
                console.log('error getUser');

            }
        });
    }

};

function confirmDeleteUser(options) {
    document.getElementById('myModal').classList.remove("tg-hidden");
    document.getElementById('modal-body').innerHTML = "Supprimer l'utilisateur ?";
    document.getElementById('modalSave').onclick = function () {
        var secure_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: 'POST',
            url: '/deleteUser/',
            data: {
                _token: secure_token,
                id: page.step,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (updatePage) {
                    log("Modification effectué.");
                    updatePage = false;
                }
            },
            error: function () {
                console.log('error');
            }
        });
    };
    document.getElementById('modalCancel').onclick = function () {
        modal.style.display = "none";
    };
    var modal = document.getElementById('myModal');
    var span = document.getElementsByClassName("close")[0];
    modal.style.display = "block";
    span.onclick = function () {
        modal.style.display = "none";
    };
}
