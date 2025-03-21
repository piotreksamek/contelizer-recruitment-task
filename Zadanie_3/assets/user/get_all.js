$(document).ready(function () {
    $('#getAllUsersButton').on('click', function (){
        $('#searchInput').val('');

        $.ajax({
            url: `/user/all`,
            method: "GET",
            success: function (data) {
                if (data.status === 'error') {
                    alert(data.message)

                    return;
                }

                let users = data.data;
                let tableBody = $("table tbody");
                tableBody.empty();

                let rows = users.map(function(user, index) {
                    return `<tr>
                        <th scope="row">${index + 1}</th>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.gender === 'male' ? 'Mężczyzna' : 'Kobieta'}</td>
                        <td>${user.status === 'active' ? 'Aktywny' : 'Nieaktywny'}</td>
                        <td><a href="/user/${user.id}/posts" class="btn btn-warning">Wpisy</a></td>
                    </tr>`;
                }).join('');

                tableBody.append(rows);
            },
        });
    });
});
