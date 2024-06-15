document.getElementById('search').addEventListener('keyup', function() {
    var query = this.value;
    fetch('../search_users.php?q=' + query)
        .then(response => response.json())
        .then(data => {
            var user_list = document.getElementById('user_list');
            user_list.innerHTML = '';
            data.forEach(function(user) {
                var li = document.createElement('li');
                li.textContent = user.nombre_completo + ' - ' + user.correo;
                user_list.appendChild(li);
            });
        });
});
